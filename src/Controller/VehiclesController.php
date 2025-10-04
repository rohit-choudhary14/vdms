<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Http\Exception\BadRequestException;
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
        $this->paginate = ['limit' => 10, 'order' => ['Vehicles.code' => 'DESC']];
        $vehicles = $this->paginate($this->Vehicles->find());
        $this->set(compact('vehicles'));
    }

    public function view($vehicle_code = null)
    {
        $vehicle = $this->Vehicles->find()
            ->where(['vehicle_code' => $vehicle_code])
            ->contain(['Maintenance', 'Insurance', 'DriverAssignments'])
            ->firstOrFail();
        $this->set('vehicle', $vehicle);
    }

    public function add()
    {
        $vehicle = $this->Vehicles->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['vehicle_code'])) {
                $data['vehicle_code'] = 'VEH-' . strtoupper(Text::uuid());
            }
            // handle uploads
            $uploads = ['registration_doc', 'bill_doc', 'photo_front', 'photo_back'];
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

    public function edit($vehicle_code = null)
    {
         if ($vehicle_code === null) {
        throw new BadRequestException('Vehicle code is required.');
    }
        $vehicle = $this->Vehicles->find()
            ->where(['vehicle_code' => $vehicle_code])
            ->firstOrFail();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $uploads = ['registration_doc', 'bill_doc', 'photo_front', 'photo_back'];

            foreach ($uploads as $field) {
                $file = $this->request->getData($field);

                if (!empty($file['name'])) {
                    if (!empty($vehicle->$field) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->$field)) {
                        unlink(WWW_ROOT . 'img' . DS . $vehicle->$field);
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
            $vehicle = $this->Vehicles->patchEntity($vehicle, $data);

            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('Vehicle updated successfully.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Please fix the errors and try again.'));
        }

        $this->set(compact('vehicle'));
    }
    public function delete($vehicle_code = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $vehicle = $this->Vehicles->find()
            ->where(['vehicle_code' => $vehicle_code])
            ->firstOrFail();
        if (!empty($vehicle->bill_doc) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->bill_doc)) {
            unlink(WWW_ROOT . 'img' . DS . $vehicle->bill_doc);
        }
        if (!empty($vehicle->registration_doc) && file_exists(WWW_ROOT . 'img'   . DS . $vehicle->registration_doc)) {
            unlink(WWW_ROOT . 'img' .  DS . $vehicle->registration_doc);
        }

        if (!empty($vehicle->photo_back) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->photo_back)) {
            unlink(WWW_ROOT . 'img' . DS . $vehicle->photo_back);
        }
        if (!empty($vehicle->photo_front) && file_exists(WWW_ROOT . 'img' . DS. $vehicle->photo_front)) {
            unlink(WWW_ROOT . 'img' . DS. $vehicle->photo_front);
        }

        if ($this->Vehicles->delete($vehicle)) {
            $this->Flash->success(__('Vehicle and associated files deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete vehicle. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
