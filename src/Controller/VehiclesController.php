<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Utility\Text;

class VehiclesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        // Auth already configured in AppController or UsersController; ensure this controller requires auth
    }

    public function index()
    {
        $this->paginate = ['limit' => 10, 'order' => ['Vehicles.id' => 'DESC']];
        $vehicles = $this->paginate($this->Vehicles->find());
        $this->set(compact('vehicles'));
    }

    public function view($id = null)
    {
        $vehicle = $this->Vehicles->get($id, ['contain' => ['Maintenance','Insurance','DriverAssignments']]);
        $this->set('vehicle', $vehicle);
    }

    public function add()
    {
        $vehicle = $this->Vehicles->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['vehicle_code'])) {
                $data['vehicle_code'] = 'VEH-'.strtoupper(Text::uuid());
            }

            // handle uploads
            $uploads = ['registration_doc','bill_doc','photo_front','photo_back'];
            foreach ($uploads as $field) {
                if (!empty($this->request->getData($field)['name'])) {
                    $file = $this->request->getData($field);
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                    move_uploaded_file($file['tmp_name'], $target);
                    $data[$field] = 'uploads/' . $name;
                }
            }

            $vehicle = $this->Vehicles->patchEntity($vehicle, $data);
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('Vehicle saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Please fix the errors and try again.'));
        }
        $this->set(compact('vehicle'));
    }

    public function edit($id = null)
    {
        $vehicle = $this->Vehicles->get($id);
        if ($this->request->is(['post','put','patch'])) {
            $data = $this->request->getData();

            $uploads = ['registration_doc','bill_doc','photo_front','photo_back'];
            foreach ($uploads as $field) {
                if (!empty($this->request->getData($field)['name'])) {
                    $file = $this->request->getData($field);
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $name = uniqid() . '_' . time() . '.' . $ext;
                    $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
                    move_uploaded_file($file['tmp_name'], $target);
                    $data[$field] = 'uploads/' . $name;
                } else {
                    unset($data[$field]); // keep existing
                }
            }

            $vehicle = $this->Vehicles->patchEntity($vehicle, $data);
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('Vehicle updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Please fix the errors and try again.'));
        }
        $this->set(compact('vehicle'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $vehicle = $this->Vehicles->get($id);
        if ($this->Vehicles->delete($vehicle)) {
            $this->Flash->success(__('Vehicle deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete vehicle.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
