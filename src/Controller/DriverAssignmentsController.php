<?php
namespace App\Controller;

use App\Controller\AppController;

class DriverAssignmentsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Drivers');
        $this->loadModel('Vehicles');
    }

    // List all assignments
    public function index()
    {
        $assignments = $this->Paginator->paginate(
            $this->DriverAssignments->find()
                ->contain(['Drivers', 'Vehicles'])
                ->order(['start_date' => 'DESC'])
        );
        $this->set(compact('assignments'));
    }

    // Add assignment
    public function add()
    {
        $assignment = $this->DriverAssignments->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['end_date'])) {
                $data['end_date'] = null;
            }

            $today = date('Y-m-d');

            // 1️⃣ Check if driver already assigned and assignment still valid
            $existingDriver = $this->DriverAssignments->find()
                ->where([
                    'driver_code' => $data['driver_code'],
                    'OR' => [
                        ['end_date >=' => $today],
                        ['end_date IS' => null]
                    ]
                ])
                ->first();

            if ($existingDriver) {
                $this->Flash->error(__('This driver is already assigned to another vehicle.'));
            } else {
                // 2️⃣ Check if vehicle already assigned and assignment still valid
                $existingVehicle = $this->DriverAssignments->find()
                    ->where([
                        'vehicle_code' => $data['vehicle_code'],
                        'OR' => [
                            ['end_date >=' => $today],
                            ['end_date IS' => null]
                        ]
                    ])
                    ->first();

                if ($existingVehicle) {
                    $this->Flash->error(__('This vehicle is already assigned to another driver.'));
                } else {
                    $assignment = $this->DriverAssignments->patchEntity($assignment, $data);
                    if ($this->DriverAssignments->save($assignment)) {
                        $this->Flash->success(__('Driver assignment saved successfully.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('Please fix errors and try again.'));
                }
            }
        }

        // ✅ Filter out drivers whose end_date >= today (still assigned)
        $today = date('Y-m-d');

        $assignedDrivers = $this->DriverAssignments->find()
            ->select(['driver_code'])
            ->where([
                'OR' => [
                    ['end_date >=' => $today],
                    ['end_date IS' => null]
                ]
            ])
            ->extract('driver_code')
            ->toArray();

        // ✅ Only include available drivers
        if (!empty($assignedDrivers)) {
            $drivers = $this->Drivers->find('list', [
                'keyField' => 'driver_code',
                'valueField' => 'name'
            ])
                ->where(['driver_code NOT IN' => $assignedDrivers])
                ->toArray();
        } else {
            $drivers = $this->Drivers->find('list', [
                'keyField' => 'driver_code',
                'valueField' => 'name'
            ])->toArray();
        }

        // ✅ Filter out vehicles whose end_date >= today (still assigned)
        $assignedVehicles = $this->DriverAssignments->find()
            ->select(['vehicle_code'])
            ->where([
                'OR' => [
                    ['end_date >=' => $today],
                    ['end_date IS' => null]
                ]
            ])
            ->extract('vehicle_code')
            ->toArray();

        if (!empty($assignedVehicles)) {
            $vehicles = $this->Vehicles->find('list', [
                'keyField' => 'vehicle_code',
                'valueField' => 'registration_no'
            ])
                ->where(['vehicle_code NOT IN' => $assignedVehicles])
                ->toArray();
        } else {
            $vehicles = $this->Vehicles->find('list', [
                'keyField' => 'vehicle_code',
                'valueField' => 'registration_no'
            ])->toArray();
        }

        $this->set(compact('assignment', 'drivers', 'vehicles'));
    }







    // Edit assignment
    public function edit($id = null)
    {
        $assignment = $this->DriverAssignments->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $assignment = $this->DriverAssignments->patchEntity($assignment, $this->request->getData());
            if ($this->DriverAssignments->save($assignment)) {
                $this->Flash->success('Driver assignment updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }

        $drivers = $this->Drivers->find('list', [
            'keyField' => 'driver_code',
            'valueField' => 'name'
        ]);
        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehical_code',
            'valueField' => 'registration_no'
        ]);
        $this->set(compact('assignment', 'drivers', 'vehicles'));
    }

    // Delete assignment
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assignment = $this->DriverAssignments->get($id);
        if ($this->DriverAssignments->delete($assignment)) {
            $this->Flash->success('Driver assignment deleted.');
        } else {
            $this->Flash->error('Unable to delete driver assignment.');
        }
        return $this->redirect(['action' => 'index']);
    }

    // View assignment details
    public function view($id = null)
    {
        $assignment = $this->DriverAssignments->get($id, ['contain' => ['Drivers', 'Vehicles']]);
        $this->set(compact('assignment'));
    }
}
