<?php
// src/Controller/InsuranceController.php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

class InsuranceController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('InsuranceCompanies');
        $this->loadModel('Vehicles');
        $this->loadComponent('Flash');
        $this->request->allowMethod(['get', 'post', 'put', 'delete']);
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Vehicles', 'InsuranceCompanies']
        ];
        $insurance = $this->paginate($this->Insurance);
        $this->set(compact('insurance'));
    }

    public function add()
    {
        $insurance = $this->Insurance->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Normalize dates from d-m-y or d-m-Y to Y-m-d for DB
            $data = $this->normalizeDatesFromForm($data);

            // Auto-calc expiry_date if start_date exists but expiry not provided
            if (!empty($data['start_date']) && empty($data['expiry_date'])) {
                $tenure = !empty($data['policy_tenure']) ? (int)$data['policy_tenure'] : 1;
                $data['expiry_date'] = date('Y-m-d', strtotime($data['start_date'] . " +{$tenure} year"));
            }

            // Auto policy_issued_date
            if (empty($data['policy_issued_date']) && !empty($data['start_date'])) {
                $data['policy_issued_date'] = $data['start_date'];
            }

            // Auto fill vehicle details if vehicle_code provided
            if (!empty($data['vehicle_code'])) {
                $vehicle = $this->Vehicles->find()->where(['vehicle_code' => $data['vehicle_code']])->first();
                if ($vehicle) {
                    $data['vehicle_year'] = $vehicle->manufacturing_year ?? $vehicle->manufacturing_year ?? null;
                    $data['fuel_type'] = $vehicle->fuel_type ?? null;
                    $data['engine_cc'] = $vehicle->engine_cc ?? null;
                }
            }

            // Calculate IDV if purchase_value present
            if (!empty($data['vehicle_code']) && empty($data['idv'])) {
                $vehicle = $this->Vehicles->find()->where(['vehicle_code' => $data['vehicle_code']])->first();
                if ($vehicle && !empty($vehicle->purchase_value)) {
                    $data['idv'] = $this->calculateIdv($vehicle->purchase_value, $vehicle->manufacturing_year ?? null);
                }
            }

            // Calculate base premium, GST and total premium if possible
            if (!empty($data['idv']) && !empty($data['ncb_percent'])) {
                $calc = $this->calculatePremiumFromIdv($data['idv'], $data['ncb_percent'], $data['addons'] ?? []);
                $data['base_premium'] = $calc['base_premium'];
                $data['gst_amount'] = $calc['gst_amount'];
                $data['total_premium'] = $calc['total_premium'];
            }

            // File upload handling (safe)
            $uploads = ['document'];
            foreach ($uploads as $field) {
                $file = $this->request->getData($field);
                if (!empty($file) && !empty($file['name'])) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $targetFolder = WWW_ROOT . 'img' . DS . 'uploads' . DS;
                    if (!is_dir($targetFolder)) {
                        mkdir($targetFolder, 0755, true);
                    }
                    $target = $targetFolder . $name;
                    move_uploaded_file($file['tmp_name'], $target);
                    $data[$field] = 'uploads' . DS . $name;
                } else {
                    unset($data[$field]);
                }
            }

            // Auto status based on expiry date
            if (!empty($data['expiry_date'])) {
                $data['status'] = (strtotime($data['expiry_date']) >= strtotime(date('Y-m-d'))) ? 'Active' : 'Expired';
            }

            $insurance = $this->Insurance->patchEntity($insurance, $data, ['associated' => []]);

            if ($this->Insurance->save($insurance)) {
                $this->Flash->success('Insurance added successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add insurance. Please correct form errors.');
        }

        // Vehicle dropdown
        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();
        $vehicles = array_map('strtoupper', $vehicles);

        // Insurance company dropdown (active)
        $insuranceCompanies = $this->InsuranceCompanies->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['status' => 'Active'])->toArray();

        $this->set(compact('insurance', 'vehicles', 'insuranceCompanies'));
    }

    public function edit($id = null)
    {
        $insurance = $this->Insurance->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Normalize date strings
            $data = $this->normalizeDatesFromForm($data);

            // File upload
            $uploads = ['document'];
            foreach ($uploads as $field) {
                $file = $this->request->getData($field);
                if (!empty($file) && !empty($file['name'])) {
                    // remove old file
                    if (!empty($insurance->$field) && file_exists(WWW_ROOT . 'img' . DS . $insurance->$field)) {
                        @unlink(WWW_ROOT . 'img' . DS . $insurance->$field);
                    }
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $targetFolder = WWW_ROOT . 'img' . DS . 'uploads' . DS;
                    if (!is_dir($targetFolder)) {
                        mkdir($targetFolder, 0755, true);
                    }
                    $target = $targetFolder . $name;
                    move_uploaded_file($file['tmp_name'], $target);
                    $data[$field] = 'uploads' . DS . $name;
                } else {
                    unset($data[$field]);
                }
            }

            // Recalculate premiums if IDV or NCB changed
            if (!empty($data['idv']) && isset($data['ncb_percent'])) {
                $calc = $this->calculatePremiumFromIdv($data['idv'], $data['ncb_percent'], $data['addons'] ?? []);
                $data['base_premium'] = $calc['base_premium'];
                $data['gst_amount'] = $calc['gst_amount'];
                $data['total_premium'] = $calc['total_premium'];
            }

            // Auto expiry if tenure changed
            if (!empty($data['start_date']) && !empty($data['policy_tenure'])) {
                $data['expiry_date'] = date('Y-m-d', strtotime($data['start_date'] . " +{$data['policy_tenure']} year"));
            }

            // Auto status
            if (!empty($data['expiry_date'])) {
                $data['status'] = (strtotime($data['expiry_date']) >= strtotime(date('Y-m-d'))) ? 'Active' : 'Expired';
            }

            $insurance = $this->Insurance->patchEntity($insurance, $data, ['associated' => []]);
            if ($this->Insurance->save($insurance)) {
                $this->Flash->success('Insurance updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update insurance. Please correct errors.');
        }

        // Vehicle dropdown
        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();

        // Insurance company dropdown
        $insuranceCompanies = $this->InsuranceCompanies->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['status' => 'Active'])->toArray();

        $this->set(compact('insurance', 'vehicles', 'insuranceCompanies'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $insurance = $this->Insurance->get($id);

        if ($this->Insurance->delete($insurance)) {
            $this->Flash->success('Insurance deleted.');
        } else {
            $this->Flash->error('Could not delete insurance.');
        }

        return $this->redirect(['action' => 'index']);
    }

    // JSON endpoint: returns vehicle details for a vehicle_code
    public function getVehicleDetails($vehicleCode = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $vehicle = $this->Vehicles->find()->where(['vehicle_code' => $vehicleCode])->first();
        if (!$vehicle) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false]));
        }

        $data = [
            'insurance_expiry_date' => $vehicle->insurance_expiry_date ?? null,
            'fuel_type' => $vehicle->fuel_type ?? null,
            'vendor' => $vehicle->vendor ?? null,
            'insurance_policy_no' => $vehicle->insurance_policy_no ?? 0
        ];

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'data' => $data]));
    }

    // JSON endpoint: returns insurance company contact & address
    public function getCompanyDetails($companyId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $company = $this->InsuranceCompanies->get($companyId);
        if (!$company) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false]));
        }

        $data = [
            'id' => $company->id,
            'name' => $company->name,
            'contact_number' => $company->contact_number ?? '',
            'address' => $company->address ?? ''
        ];

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'data' => $data]));
    }

    /**
     * Calculate IDV based on purchase_value and manufacturing year.
     * Simple depreciation table used (industry-like).
     */
    protected function calculateIdv($purchaseValue, $manufacturingYear = null)
    {
        if (empty($purchaseValue)) {
            return null;
        }
        $currentYear = (int)date('Y');
        $age = $manufacturingYear ? max(0, $currentYear - (int)$manufacturingYear) : 0;

        // Depreciation table (common example)
        if ($age < 1) $depr = 0.05;
        elseif ($age < 2) $depr = 0.15;
        elseif ($age < 3) $depr = 0.20;
        elseif ($age < 4) $depr = 0.30;
        elseif ($age < 5) $depr = 0.40;
        else $depr = 0.50;

        $idv = $purchaseValue * (1 - $depr);
        return round($idv, 2);
    }

    /**
     * Calculate premium using IDV and NCB plus addons.
     * This is a simple formula; replace with your actuarial rules.
     */
    protected function calculatePremiumFromIdv($idv, $ncbPercent = 0, $addons = [])
    {
        $ncbPercent = (int)$ncbPercent;
        // base premium = 2.5% of IDV (example). You should adjust logic as required.
        $baseRate = 0.025;
        $basePremium = round($idv * $baseRate, 2);

        // Apply NCB discount
        $discount = ($ncbPercent / 100) * $basePremium;
        $premiumAfterNcb = max(0, $basePremium - $discount);

        // Add-ons flat rates (example)
        $addonTotal = 0.00;
        $addonsMap = [
            'zero_depreciation' => 0.05 * $basePremium,
            'engine_protection' => 0.04 * $basePremium,
            'roadside_assistance' => 200.00,
            'return_to_invoice' => 0.03 * $basePremium,
            'key_replacement' => 150.00,
            'consumables' => 250.00,
            'ncb_protection' => 0.02 * $basePremium,
            'personal_accident' => 100.00
        ];
        if (!empty($addons) && is_array($addons)) {
            foreach ($addons as $a) {
                if (isset($addonsMap[$a])) $addonTotal += $addonsMap[$a];
            }
        }

        $subTotal = $premiumAfterNcb + $addonTotal;

        // GST 18% (example)
        $gst = round(0.18 * $subTotal, 2);
        $total = round($subTotal + $gst, 2);

        return [
            'base_premium' => round($subTotal, 2),
            'gst_amount' => $gst,
            'total_premium' => $total
        ];
    }

    /**
     * Convert d-m-y or d-m-Y form input to Y-m-d
     */
    protected function normalizeDatesFromForm(array $data): array
    {
        $dateFields = ['start_date', 'expiry_date', 'policy_issued_date', 'next_due', 'previous_policy_expiry'];
        foreach ($dateFields as $f) {
            if (!empty($data[$f])) {
                // Accept dd-mm-yy or dd-mm-yyyy (from your flatpickr)
                $parts = preg_split('/-/', $data[$f]);
                if (count($parts) === 3) {
                    $d = (int)$parts[0];
                    $m = (int)$parts[1];
                    $y = (int)$parts[2];
                    // two-digit year handling
                    if ($y < 100) $y += 2000;
                    $data[$f] = date('Y-m-d', strtotime("{$y}-{$m}-{$d}"));
                }
            }
        }
        return $data;
    }
}
