<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

class DriversController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function index()
    {
        $drivers = $this->paginate($this->Drivers);
        $this->set(compact('drivers'));
    }

    public function view($id = null)
    {
        $driver = $this->Drivers->get($id);
        $this->set('driver', $driver);
    }

    public function add()
    {
        $driver = $this->Drivers->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($this->request->getData('photo')['name'])) {
                $file = $this->request->getData('photo');
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = uniqid() . '_' . time() . '.' . $ext;
                $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                move_uploaded_file($file['tmp_name'], $target);
                $data['photo'] = 'uploads/' . $name;
            }
            $driver = $this->Drivers->patchEntity($driver, $data);
            if ($this->Drivers->save($driver)) {
                $this->Flash->success(__('Driver saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Fix errors and try again.'));
        }
        $this->set(compact('driver'));
    }

    public function edit($id = null)
    {
        $driver = $this->Drivers->get($id);
        if ($this->request->is(['post','put','patch'])) {
            $data = $this->request->getData();
            if (!empty($this->request->getData('photo')['name'])) {
                $file = $this->request->getData('photo');
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = uniqid() . '_' . time() . '.' . $ext;
                $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                move_uploaded_file($file['tmp_name'], $target);
                $data['photo'] = 'uploads/' . $name;
            } else {
                unset($data['photo']);
            }
            $driver = $this->Drivers->patchEntity($driver, $data);
            if ($this->Drivers->save($driver)) {
                $this->Flash->success(__('Driver updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Fix errors and try again.'));
        }
        $this->set(compact('driver'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $driver = $this->Drivers->get($id);
        if ($this->Drivers->delete($driver)) {
            $this->Flash->success(__('Driver deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete driver.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
