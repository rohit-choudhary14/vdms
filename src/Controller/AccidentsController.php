<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class AccidentsController extends AppController
{
    public function index()
    {
        $accidents = $this->Accidents->find('all', [
            'contain' => ['Vehicles', 'Drivers']
        ]);
        $this->set(compact('accidents'));
    }

    public function exportExcel()
    {
        $this->autoRender = false;

        $accidents = $this->Accidents->find('all', [
            'contain' => ['Vehicles', 'Drivers']
        ])->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Accident ID');
        $sheet->setCellValue('B1', 'Vehicle');
        $sheet->setCellValue('C1', 'Driver');
        $sheet->setCellValue('D1', 'Date & Time');
        $sheet->setCellValue('E1', 'Location');
        $sheet->setCellValue('F1', 'Nature');
        $sheet->setCellValue('G1', 'Repair Cost');
        $sheet->setCellValue('H1', 'Insurance Status');

        // Rows
        $row = 2;
        foreach ($accidents as $accident) {
            $sheet->setCellValue("A{$row}", $accident->accident_id);
            $sheet->setCellValue("B{$row}", !empty($accident->vehicle->registration_no) ? $accident->vehicle->registration_no : $accident->vehicle_id);
            $sheet->setCellValue("C{$row}", !empty($accident->driver->name) ? $accident->driver->name : $accident->driver_id);
            $sheet->setCellValue("D{$row}", $accident->date_time->format('d-m-Y H:i'));
            $sheet->setCellValue("E{$row}", $accident->location);
            $sheet->setCellValue("F{$row}", $accident->nature_of_accident);
            $sheet->setCellValue("G{$row}", $accident->repair_cost);
            $sheet->setCellValue("H{$row}", $accident->insurance_claim_status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "accident_report_" . date('YmdHis') . ".xlsx";
        $this->response = $this->response->withDownload($filename);
        $writer->save('php://output');
    }

    public function exportPdf()
    {
        $this->autoRender = false;

        $accidents = $this->Accidents->find('all', [
            'contain' => ['Vehicles', 'Drivers']
        ])->toArray();

        $html = '<h2>Accident / Incident Report</h2>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
        <tr>
            <th>ID</th><th>Vehicle</th><th>Driver</th><th>Date & Time</th>
            <th>Location</th><th>Nature</th><th>Repair Cost</th><th>Insurance</th>
        </tr>
        </thead><tbody>';

        foreach ($accidents as $a) {
            $html .= '<tr>
            <td>' . $a->accident_id . '</td>
            <td>' . (!empty($a->vehicle->registration_no) ? $a->vehicle->registration_no : $a->vehicle_id) . '</td>
            <td>' . (!empty($a->driver->name) ? $a->driver->name : $a->driver_id) . '</td>
            <td>' . $a->date_time->format('d-m-Y H:i') . '</td>
            <td>' . $a->location . '</td>
            <td>' . $a->nature_of_accident . '</td>
            <td>' . $a->repair_cost . '</td>
            <td>' . $a->insurance_claim_status . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = "accident_report_" . date('YmdHis') . ".pdf";
        $dompdf->stream($filename, ["Attachment" => true]);
    }

    public function report()
    {
        $this->loadModel('Vehicles');
        $this->loadModel('Drivers');

        $query = $this->Accidents->find('all', [
            'contain' => ['Vehicles', 'Drivers']
        ]);

        $filters = $this->request->getQuery();

        if (!empty($filters['vehicle_id'])) {
            $query->where(['Accidents.vehicle_id' => $filters['vehicle_id']]);
        }
        if (!empty($filters['driver_id'])) {
            $query->where(['Accidents.driver_id' => $filters['driver_id']]);
        }
        if (!empty($filters['nature_of_accident'])) {
            $query->where(['Accidents.nature_of_accident' => $filters['nature_of_accident']]);
        }
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $from = date('Y-m-d 00:00:00', strtotime($filters['from_date']));
            $to = date('Y-m-d 23:59:59', strtotime($filters['to_date']));
            $query->where(function ($exp) use ($from, $to) {
                return $exp->between('Accidents.date_time', $from, $to);
            });
        }

        $accidents = $query->all();

        $vehicles = $this->Vehicles->find('list', ['keyField' => 'vehicle_code', 'valueField' => 'registration_no']);
        $drivers = $this->Drivers->find('list', ['keyField' => 'driver_code', 'valueField' => 'name']);

        $this->set(compact('accidents', 'vehicles', 'drivers', 'filters'));
    }

    public function view($id = null)
    {
        $accident = $this->Accidents->get($id, [
            'contain' => ['Vehicles', 'Drivers']
        ]);
        $this->set(compact('accident'));
    }

    public function add()
    {
        $accident = $this->Accidents->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Handle FIR checkbox and related fields
            if (empty($data['is_fir_registered'])) {
                $data['is_fir_registered'] = false;
                $data['fir_no'] = null;
                $data['fir_date'] = null;
                $data['supporting_docs'] = null;
            } else {
                $data['is_fir_registered'] = true;

                if (!empty($data['fir_date'])) {
                    $date = \DateTime::createFromFormat('d-m-Y', $data['fir_date']);
                    if ($date) {
                        $data['fir_date'] = $date->format('Y-m-d');
                    }
                }

                $data['supporting_docs'] = $this->handleFirDocumentsUpload($this->request->getData('supporting_docs'));
                if (!empty($data['supporting_docs'])) {
                    $data['supporting_docs'] = json_encode($data['supporting_docs']);
                } else {
                    $data['supporting_docs'] = null;
                }
            }

            $accident = $this->Accidents->patchEntity($accident, $data);

            if ($this->Accidents->save($accident)) {
                $this->Flash->success(__('Accident record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save accident record.'));
        }

        $vehicles = $this->Accidents->Vehicles->find('list', ['keyField' => 'vehicle_code', 'valueField' => 'registration_no']);
        $drivers = $this->Accidents->Drivers->find('list', ['keyField' => 'driver_code', 'valueField' => 'name']);
        $this->set(compact('accident', 'vehicles', 'drivers'));
    }

    public function edit($id = null)
    {
        $accident = $this->Accidents->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (empty($data['is_fir_registered'])) {
                $data['is_fir_registered'] = false;
                $data['fir_no'] = null;
                $data['fir_date'] = null;
                $data['supporting_docs'] = null;
            } else {
                $data['is_fir_registered'] = true;

                if (!empty($data['fir_date'])) {
                    $date = \DateTime::createFromFormat('d-m-Y', $data['fir_date']);
                    if ($date) {
                        $data['fir_date'] = $date->format('Y-m-d');
                    }
                }

                $uploadedFiles = $this->request->getData('supporting_docs');

                $existingDocs = json_decode($accident->supporting_docs, true) ?: [];
                $newDocs = $this->handleFirDocumentsUpload($uploadedFiles);

                $allDocs = array_merge($existingDocs, $newDocs);
                $data['supporting_docs'] = !empty($allDocs) ? json_encode($allDocs) : null;
            }

            $accident = $this->Accidents->patchEntity($accident, $data);

            if ($this->Accidents->save($accident)) {
                $this->Flash->success(__('Accident record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update accident record.'));
        }

        $vehicles = $this->Accidents->Vehicles->find('list', ['keyField' => 'vehicle_code', 'valueField' => 'registration_no']);
        $drivers = $this->Accidents->Drivers->find('list', ['keyField' => 'driver_code', 'valueField' => 'name']);
        $this->set(compact('accident', 'vehicles', 'drivers'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accident = $this->Accidents->get($id);
        if ($this->Accidents->delete($accident)) {
            $this->Flash->success(__('Accident record has been deleted.'));
        } else {
            $this->Flash->error(__('Could not delete accident record.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Upload and save FIR supporting documents (PDF only).
     * Supports single or multiple files.
     * Returns array of saved file names.
     */
    private function handleFirDocumentsUpload($uploadedFiles)
    {
        $savedFiles = [];

        if (empty($uploadedFiles)) {
            return $savedFiles;
        }

        // Multiple files case
        if (is_array($uploadedFiles) && isset($uploadedFiles[0]['tmp_name'])) {
            foreach ($uploadedFiles as $file) {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $mime = mime_content_type($file['tmp_name']);
                    if ($mime === 'application/pdf') {
                        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '', $file['name']);
                        $targetPath = WWW_ROOT . 'uploads' . DS . 'fir_docs' . DS . $fileName;

                        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                            $savedFiles[] = $fileName;
                        }
                    }
                }
            }
        }
        // Single file case
        elseif (isset($uploadedFiles['tmp_name']) && $uploadedFiles['error'] === UPLOAD_ERR_OK) {
            $mime = mime_content_type($uploadedFiles['tmp_name']);
            if ($mime === 'application/pdf') {
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '', $uploadedFiles['name']);
                $targetPath = WWW_ROOT . 'uploads' . DS . 'fir_docs' . DS . $fileName;

                if (move_uploaded_file($uploadedFiles['tmp_name'], $targetPath)) {
                    $savedFiles[] = $fileName;
                }
            }
        }

        return $savedFiles;
    }
}
