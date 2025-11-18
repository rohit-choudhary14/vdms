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
            $this->Maintenance->find()->contain(['Vehicles'])->order(['service_date' => 'DESC'])
        );
        $this->set(compact('maintenance'));
    }
    public function add()
    {
        $record = $this->Maintenance->newEntity();
        if ($this->request->is('post')) {
            $uploads = ['bill_document'];
            foreach ($uploads as $field) {
                if (!empty($this->request->getData($field)['name'])) {
                    $file = $this->request->getData($field);
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                    move_uploaded_file($file['tmp_name'], $target);
                    $data[$field] = "uploads/$name";
                }
            }
            $record = $this->Maintenance->patchEntity($record, $this->request->getData());
            if ($this->Maintenance->save($record)) {
                $this->Flash->success('Maintenance record added successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }
        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();
        $this->set(compact('record', 'vehicles'));
    }
    public function edit($id = null)
    {
        $record = $this->Maintenance->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {

             $uploads = ['bill_document'];
            foreach ($uploads as $field) {
                $file = $this->request->getData($field);

                if (!empty($file['name'])) {
                    if (!empty($record->$field) && file_exists(WWW_ROOT . 'img' . DS . $record->$field)) {
                        unlink(WWW_ROOT . 'img' . DS . $record->$field);
                    }

                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                    move_uploaded_file($file['tmp_name'], $target);

                    $data[$field] = 'uploads' . DS . $name;
                } else {
                    unset($data[$field]);
                }
            }
            $record = $this->Maintenance->patchEntity($record, $this->request->getData());
            if ($this->Maintenance->save($record)) {
                $this->Flash->success('Maintenance record updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }

        $vehicles = $this->Vehicles->find('list');
        $this->set(compact('record', 'vehicles'));
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $record = $this->Maintenance->get($id);
        if ($this->Maintenance->delete($record)) {
            $this->Flash->success('Maintenance record deleted.');
        } else {
            $this->Flash->error('Unable to delete maintenance record.');
        }
        return $this->redirect(['action' => 'index']);
    }
    public function view($id = null)
    {
        $record = $this->Maintenance->get($id, ['contain' => ['Vehicles']]);
        $this->set(compact('record'));
    }
}
