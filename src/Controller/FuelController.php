<?php namespace App\Controller;

use App\Controller\AppController;

class FuelController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Fuel');
    }

    public function index()
    {
        $fuelLogs = $this->paginate($this->Fuel->find('all', ['contain' => ['Vehicles', 'Drivers']]));
        $this->set(compact('fuelLogs'));
    }

    public function add()
    {
        $fuelLog = $this->Fuel->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $lastLog = $this->Fuel->find()
                ->where(['vehicle_code' => $data['vehicle_code']])
                ->order(['refuel_date' => 'DESC'])
                ->first();

            if ($lastLog) {
                $distance = $data['odometer_reading'] - $lastLog->odometer_reading;
                $data['mileage'] = ($distance > 0 && $data['fuel_quantity'] > 0) ? round($distance / $data['fuel_quantity'], 2) : 0;
            } else {
                $data['mileage'] = ($data['fuel_quantity'] > 0) ? round($data['odometer_reading'] / $data['fuel_quantity'], 2) : 0;
            }

            $fuelLog = $this->Fuel->patchEntity($fuelLog, $data);
            if ($this->Fuel->save($fuelLog)) {
                $this->Flash->success('Fuel log added successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add fuel log.');
        }

        $vehicles = $this->Fuel->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();
        $drivers = $this->Fuel->Drivers->find('list', [
            'keyField' => 'driver_code',
            'valueField' => 'name'
        ])->toArray();
        $this->set(compact('fuelLog', 'vehicles', 'drivers'));
    }

    public function edit($id = null)
    {
        $fuelLog = $this->Fuel->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $lastLog = $this->Fuel->find()
                ->where(['vehicle_code' => $fuelLog->vehicle_code, 'id !=' => $fuelLog->id])
                ->order(['refuel_date' => 'DESC'])
                ->first();

            if ($lastLog) {
                $distance = $data['odometer_reading'] - $lastLog->odometer_reading;
                $data['mileage'] = ($distance > 0 && $data['fuel_quantity'] > 0) ? round($distance / $data['fuel_quantity'], 2) : 0;
            } else {
                $data['mileage'] = ($data['fuel_quantity'] > 0) ? round($data['odometer_reading'] / $data['fuel_quantity'], 2) : 0;
            }

            $fuelLog = $this->Fuel->patchEntity($fuelLog, $data);
            if ($this->Fuel->save($fuelLog)) {
                $this->Flash->success('Fuel log updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to update fuel log.');
        }

        $vehicles = $this->Fuel->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();
        $drivers = $this->Fuel->Drivers->find('list', [
            'keyField' => 'driver_code',
            'valueField' => 'name'
        ])->toArray();
        $this->set(compact('fuelLog', 'vehicles', 'drivers'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fuelLog = $this->Fuel->get($id);
        if ($this->Fuel->delete($fuelLog)) {
            $this->Flash->success('Fuel log deleted.');
        } else {
            $this->Flash->error('Unable to delete fuel log.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
