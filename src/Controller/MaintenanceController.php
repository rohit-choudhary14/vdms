<?php
namespace App\Controller;

use App\Controller\AppController;

class MaintenanceController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Vehicles');
    }

    // Index - List all maintenance records
    public function index()
    {
        $maintenance = $this->Paginator->paginate(
            $this->Maintenance->find()->contain(['Vehicles'])->order(['service_date'=>'DESC'])
        );
        $this->set(compact('maintenance'));
    }

    // Add new maintenance record
    public function add()
    {
        $record = $this->Maintenance->newEntity();
        if ($this->request->is('post')) {
            $record = $this->Maintenance->patchEntity($record, $this->request->getData());
            if ($this->Maintenance->save($record)) {
                $this->Flash->success('Maintenance record added successfully.');
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }
        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();
        // $vehicles = $this->Vehicles->find('list');
        $this->set(compact('record','vehicles'));
    }

    // Edit maintenance record
    public function edit($id = null)
    {
        $record = $this->Maintenance->get($id);
        if ($this->request->is(['post','put','patch'])) {
            $record = $this->Maintenance->patchEntity($record, $this->request->getData());
            if ($this->Maintenance->save($record)) {
                $this->Flash->success('Maintenance record updated successfully.');
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }

        $vehicles = $this->Vehicles->find('list');
        $this->set(compact('record','vehicles'));
    }

    // Delete maintenance record
    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $record = $this->Maintenance->get($id);
        if ($this->Maintenance->delete($record)) {
            $this->Flash->success('Maintenance record deleted.');
        } else {
            $this->Flash->error('Unable to delete maintenance record.');
        }
        return $this->redirect(['action'=>'index']);
    }

    // View maintenance record details
    public function view($id = null)
    {
        $record = $this->Maintenance->get($id, ['contain'=>['Vehicles']]);
        $this->set(compact('record'));
    }
}
