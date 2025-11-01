<?php
// src/Controller/InsuranceController.php
namespace App\Controller;

use Cake\ORM\TableRegistry;

class InsuranceController extends AppController
{
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

            // Handle file upload
            $uploads = ['document'];
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

            $insurance = $this->Insurance->patchEntity($insurance, $data);
            if ($this->Insurance->save($insurance)) {
                $this->Flash->success('Insurance added successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add insurance.');
        }

        // Vehicle dropdown
        $vehicles = $this->Insurance->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();

        // Insurance company dropdown
        $this->loadModel('InsuranceCompanies');
        $insuranceCompanies = $this->InsuranceCompanies->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['status' => 'Active'])->toArray();

        $this->set(compact('insurance', 'vehicles', 'insuranceCompanies'));
    }

    public function edit($id = null)
    {
        $insurance = $this->Insurance->get($id, [
            'contain' => ['Vehicles', 'InsuranceCompanies']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // File upload
            $uploads = ['document'];
            foreach ($uploads as $field) {
                $file = $this->request->getData($field);
                if (!empty($file['name'])) {
                    if (!empty($insurance->$field) && file_exists(WWW_ROOT . 'img' . DS . $insurance->$field)) {
                        unlink(WWW_ROOT . 'img' . DS . $insurance->$field);
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

            $insurance = $this->Insurance->patchEntity($insurance, $data);
            if ($this->Insurance->save($insurance)) {
                $this->Flash->success('Insurance updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update insurance.');
        }

        // Vehicle dropdown
        $vehicles = $this->Insurance->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();

        // Insurance company dropdown
        $this->loadModel('InsuranceCompanies');
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
}
