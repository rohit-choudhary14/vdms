<?php
// src/Controller/InsuranceController.php
namespace App\Controller;

class InsuranceController extends AppController
{
    public function index()
    {
        $this->paginate = ['contain' => ['Vehicles']];
        $insurance = $this->paginate($this->Insurance);

        $this->set(compact('insurance'));
    }

    public function add()
    {
        $insurance = $this->Insurance->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

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
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add insurance.');
        }
        $vehicles = $this->Insurance->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();

        $this->set(compact('insurance', 'vehicles'));
    }

    public function edit($id = null)
    {
        $insurance = $this->Insurance->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
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
                $this->Flash->success('Insurance updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update insurance.');
        }
        $vehicles = $this->Insurance->Vehicles->find()->firstOrFail();
     
        $this->set(compact('insurance', 'vehicles'));
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
