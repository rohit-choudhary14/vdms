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
        $this->loadModel('DriverAssignments'); // load assignments table
        $this->loadModel('Vehicles');         // load vehicles table
    }

    // List all drivers
    public function index()
    {
        $drivers = $this->Paginator->paginate($this->Drivers->find());
        $this->set(compact('drivers'));
    }

    // View single driver with current vehicle
    public function view($driver_code = null)
    {
        $driver = $this->Drivers->find()
            ->where(['driver_code' => $driver_code])
            ->firstOrFail();

        // Get the latest active assignment for the driver
        $assignment = $this->DriverAssignments->find()
            ->where([
                'driver_code' => $driver->driver_code,
                // 'start_date <=' => date('Y-m-d'),
                // 'OR' => [
                //     'end_date IS NULL',
                //     'end_date >=' => date('Y-m-d')
                // ]
            ])
            ->order(['start_date' => 'DESC'])
            ->first();

        $vehicle = null;
        if ($assignment) {
            $vehicle = $this->Vehicles->find()
                ->where(['vehicle_code' => $assignment->vehicle_code])
                ->firstOrFail();

        }

        $this->set(compact('driver', 'vehicle'));
    }

    // Add new driver
    public function add()
    {
        $driver = $this->Drivers->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (empty($data['driver_code'])) {
                $data['driver_code'] = 'DRV-' . strtoupper(Text::uuid());
            }
            $uploads = ['driver_photo', 'license_doc'];
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


            $driver = $this->Drivers->patchEntity($driver, $data);
            if ($this->Drivers->save($driver)) {
                $this->Flash->success('Driver saved successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }
        $this->set(compact('driver'));
    }

    // Edit driver
    public function edit($driver_code = null)
    {
        $driver = $this->Drivers->find()
            ->where(['driver_code' => $driver_code])
            ->firstOrFail();
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $uploads = ['driver_photo', 'license_doc'];
            foreach ($uploads as $field) {
                $file = $this->request->getData($field);

                if (!empty($file['name'])) {
                    if (!empty($driver->$field) && file_exists(WWW_ROOT . 'img' . DS . $driver->$field)) {
                        unlink(WWW_ROOT . 'img' . DS . $driver->$field);
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
            $driver = $this->Drivers->patchEntity($driver, $data);
            if ($this->Drivers->save($driver)) {
                $this->Flash->success('Driver updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }
        $this->set(compact('driver'));
    }


    // Delete driver
    public function delete($driver_code = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $driver = $this->Drivers->find()->
            where(['driver_code' => $driver_code])
            ->firstOrFail();
        if (!empty($driver->license_doc) && file_exists(WWW_ROOT . 'img' . DS . $driver->license_doc)) {
            unlink(WWW_ROOT . 'img' . DS . $driver->license_doc);
        }

        if (!empty($driver->driver_photo) && file_exists(WWW_ROOT . 'img' . DS . $driver->driver_photo)) {
            unlink(WWW_ROOT . 'img' . DS . $driver->driver_photo);
        }
        if ($this->Drivers->delete($driver)) {
            $this->Flash->success('Driver deleted successfully.');
        } else {
            $this->Flash->error('Unable to delete driver.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
