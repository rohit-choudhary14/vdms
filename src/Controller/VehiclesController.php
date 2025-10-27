<?php
// namespace App\Controller;

// use App\Controller\AppController;
// use Cake\Filesystem\File;
// use Cake\Http\Exception\BadRequestException;
// use Cake\Utility\Text;

// class VehiclesController extends AppController
// {
//     public function initialize()
//     {
//         parent::initialize();
//         $this->loadComponent('Paginator');
//         // Auth already configured in AppController or UsersController; ensure this controller requires auth
//     }

//     public function index()
//     {
//         $this->paginate = ['limit' => 10, 'order' => ['Vehicles.code' => 'DESC']];
//         $vehicles = $this->paginate($this->Vehicles->find());
//         $this->set(compact('vehicles'));
//     }

//     public function view($vehicle_code = null)
//     {
//         $vehicle = $this->Vehicles->find()
//             ->where(['vehicle_code' => $vehicle_code])
//             ->contain(['Maintenance', 'Insurance', 'DriverAssignments'])
//             ->firstOrFail();
//         $this->set('vehicle', $vehicle);
//     }

//     public function add()
//     {
//         $vehicle = $this->Vehicles->newEntity();
//         if ($this->request->is('post')) {
//             $data = $this->request->getData();

//             if (empty($data['vehicle_code'])) {
//                 $data['vehicle_code'] = 'VEH-' . strtoupper(Text::uuid());
//             }
//             // handle uploads
//             $uploads = ['registration_doc', 'bill_doc', 'photo_front', 'photo_back'];
//             foreach ($uploads as $field) {
//                 if (!empty($this->request->getData($field)['name'])) {
//                     $file = $this->request->getData($field);
//                     $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
//                     $name = uniqid() . '_' . time() . '.' . $ext;
//                     $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
//                     move_uploaded_file($file['tmp_name'], $target);
//                     $data[$field] = 'uploads/' . $name;
//                 }
//             }
//             $vehicle = $this->Vehicles->patchEntity($vehicle, $data);
//             if ($this->Vehicles->save($vehicle)) {
//                 $this->Flash->success(__('Vehicle saved.'));
//                 return $this->redirect(['action' => 'index']);
//             }
//             $this->Flash->error(__('Please fix the errors and try again.'));
//         }
//         $this->set(compact('vehicle'));
//     }

//     public function edit($vehicle_code = null)
//     {
//          if ($vehicle_code === null) {
//         throw new BadRequestException('Vehicle code is required.');
//     }
//         $vehicle = $this->Vehicles->find()
//             ->where(['vehicle_code' => $vehicle_code])
//             ->firstOrFail();

//         if ($this->request->is(['post', 'put', 'patch'])) {
//             $data = $this->request->getData();

//             $uploads = ['registration_doc', 'bill_doc', 'photo_front', 'photo_back'];

//             foreach ($uploads as $field) {
//                 $file = $this->request->getData($field);

//                 if (!empty($file['name'])) {
//                     if (!empty($vehicle->$field) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->$field)) {
//                         unlink(WWW_ROOT . 'img' . DS . $vehicle->$field);
//                     }
//                     $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
//                     $name = uniqid() . '_' . time() . '.' . $ext;
//                     $target = WWW_ROOT . 'img' . DS . 'uploads' . DS . $name;
//                     move_uploaded_file($file['tmp_name'], $target);

//                     $data[$field] = 'uploads' . DS . $name;
//                 } else {
//                     unset($data[$field]);
//                 }
//             }
//             $vehicle = $this->Vehicles->patchEntity($vehicle, $data);

//             if ($this->Vehicles->save($vehicle)) {
//                 $this->Flash->success(__('Vehicle updated successfully.'));
//                 return $this->redirect(['action' => 'index']);
//             }

//             $this->Flash->error(__('Please fix the errors and try again.'));
//         }

//         $this->set(compact('vehicle'));
//     }
//     public function delete($vehicle_code = null)
//     {
//         $this->request->allowMethod(['post', 'delete']);

//         $vehicle = $this->Vehicles->find()
//             ->where(['vehicle_code' => $vehicle_code])
//             ->firstOrFail();
//         if (!empty($vehicle->bill_doc) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->bill_doc)) {
//             unlink(WWW_ROOT . 'img' . DS . $vehicle->bill_doc);
//         }
//         if (!empty($vehicle->registration_doc) && file_exists(WWW_ROOT . 'img'   . DS . $vehicle->registration_doc)) {
//             unlink(WWW_ROOT . 'img' .  DS . $vehicle->registration_doc);
//         }

//         if (!empty($vehicle->photo_back) && file_exists(WWW_ROOT . 'img' . DS . $vehicle->photo_back)) {
//             unlink(WWW_ROOT . 'img' . DS . $vehicle->photo_back);
//         }
//         if (!empty($vehicle->photo_front) && file_exists(WWW_ROOT . 'img' . DS. $vehicle->photo_front)) {
//             unlink(WWW_ROOT . 'img' . DS. $vehicle->photo_front);
//         }

//         if ($this->Vehicles->delete($vehicle)) {
//             $this->Flash->success(__('Vehicle and associated files deleted.'));
//         } else {
//             $this->Flash->error(__('Unable to delete vehicle. Please try again.'));
//         }

//         return $this->redirect(['action' => 'index']);
//     }

// }
/**
 * UPDATED VehiclesController.php with Master Table Integration
 * Location: src/Controller/VehiclesController.php
 */

namespace App\Controller;
use App\Controller\AppController;
use Cake\Http\Response;

class VehiclesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        
        // Load master tables
        $this->loadModel('VehicleTypes');
        $this->loadModel('VehicleManufacturers'); 
        $this->loadModel('VehicleModels');
        $this->loadModel('ModelYears');
    }

    /**
     * Index method - List all vehicles
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'VehicleTypes',
                'VehicleManufacturers', 
                'VehicleModels'
            ]
        ];
        $vehicles = $this->paginate($this->Vehicles);

        $this->set(compact('vehicles'));
    }

    /**
     * Add method - Create new vehicle  
     */
    public function add()
    {
        $vehicle = $this->Vehicles->newEntity();
        
        if ($this->request->is('post')) {
            $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());
            
            
            // Auto-generate vehicle code if not provided
            if (empty($vehicle->vehicle_code)) {
                $vehicle->vehicle_code = $this->generateVehicleCode();
            }
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
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('The vehicle has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
        }
        
        // Load dropdown data for form
        $vehicleTypes = $this->VehicleTypes->find('list', [
            'keyField' => 'id',
            'valueField' => 'type_name'
        ])->toArray();
        
        $manufacturers = $this->VehicleManufacturers->find('list', [
            'keyField' => 'id', 
            'valueField' => 'name'
        ])->order(['name' => 'ASC'])->toArray();

        $this->set(compact('vehicle', 'vehicleTypes', 'manufacturers'));
    }

    /**
     * Edit method - Update existing vehicle
     */
    public function edit($vehicleCode = null)
{
    $vehicle = $this->Vehicles->find()
        ->where(['vehicle_code' => $vehicleCode])
        ->contain(['VehicleTypes', 'VehicleManufacturers', 'VehicleModels'])
        ->firstOrFail();

    if ($this->request->is(['patch', 'post', 'put'])) {
        $vehicle = $this->Vehicles->patchEntity($vehicle, $this->request->getData());
        if ($this->Vehicles->save($vehicle)) {
            $this->Flash->success(__('The vehicle has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
    }

    // Load dropdown data as before
    $vehicleTypes = $this->VehicleTypes->find('list', [
        'keyField' => 'id',
        'valueField' => 'type_name'
    ])->toArray();

    $manufacturers = $this->VehicleManufacturers->find('list', [
        'keyField' => 'id',
        'valueField' => 'name'
    ])->order(['name' => 'ASC'])->toArray();

    $models = [];
    $years = [];

    if (!empty($vehicle->manufacturer_id)) {
        $models = $this->VehicleModels->find('list', [
            'keyField' => 'id',
            'valueField' => 'model_name',
            'conditions' => ['manufacturer_id' => $vehicle->manufacturer_id]
        ])->order(['model_name' => 'ASC'])->toArray();
    }

    if (!empty($vehicle->model_id)) {
        $years = $this->ModelYears->getAvailableYears($vehicle->model_id);
        $years = array_combine($years, $years);
    }

    $this->set(compact('vehicle', 'vehicleTypes', 'manufacturers', 'models', 'years'));
}

    /**
     * AJAX method - Get models by manufacturer
     */
    public function getModels()
    {
        $this->request->allowMethod(['post', 'ajax']);
        
        $manufacturerId = $this->request->getData('manufacturer_id');
        
        if (!empty($manufacturerId)) {
            $models = $this->VehicleModels->find()
                ->where(['manufacturer_id' => $manufacturerId])
                ->contain(['VehicleTypes'])
                ->order(['model_name' => 'ASC'])
                ->toArray();
            
            $modelData = [];
            foreach ($models as $model) {
                $modelData[] = [
                    'id' => $model->id,
                    'model_name' => $model->model_name,
                    'seating_capacity' => $model->seating_capacity,
                    'fuel_type' => $model->fuel_type,
                    'vehicle_type' => $model->vehicle_type->type_name ?? ''
                ];
            }
            
            $response = [
                'success' => true,
                'models' => $modelData
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No manufacturer selected'
            ];
        }
        
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($response));
        return $this->response;
    }

    /**
     * AJAX method - Get available years for a model
     */
    public function getModelYears()
    {
        $this->request->allowMethod(['post', 'ajax']);
        
        $modelId = $this->request->getData('model_id');
        
        if (!empty($modelId)) {
            $years = $this->ModelYears->getAvailableYears($modelId);
            
            $response = [
                'success' => true,
                'years' => $years
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No model selected'
            ];
        }
        
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($response));
        return $this->response;
    }

    /**
     * View method
     */
   public function view($vehicleCode = null)
{
    $vehicle = $this->Vehicles->find()
        ->where(['vehicle_code' => $vehicleCode])
        ->contain([
            'VehicleTypes',
            'VehicleManufacturers',
            'VehicleModels',
            'Insurance'
        ])
        ->firstOrFail();
    $this->set(compact('vehicle'));
}


    /**
     * Delete method
     */
    public function delete($vehicleCode = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $vehicle = $this->Vehicles->find()
        ->where(['vehicle_code' => $vehicleCode])
        ->firstOrFail();

    if ($this->Vehicles->delete($vehicle)) {
        $this->Flash->success(__('The vehicle has been deleted.'));
    } else {
        $this->Flash->error(__('The vehicle could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
}
    /**
     * Generate unique vehicle code
     */
    private function generateVehicleCode()
    {
        do {
            $code = 'VEH-' . strtoupper(uniqid());
        } while ($this->Vehicles->exists(['vehicle_code' => $code]));
        
        return $code;
    }

    // ========================================
    // MASTER DATA MANAGEMENT METHODS
    // ========================================

    /**
     * Manage Vehicle Types
     */
    public function manageTypes()
    {
        $types = $this->VehicleTypes->find('all')->order(['type_name' => 'ASC']);
        $this->set(compact('types'));
    }

    /**
     * Add Vehicle Type
     */
    public function addType()
    {
        $type = $this->VehicleTypes->newEntity();
        
        if ($this->request->is('post')) {
            $type = $this->VehicleTypes->patchEntity($type, $this->request->getData());
            if ($this->VehicleTypes->save($type)) {
                $this->Flash->success(__('Vehicle type has been added.'));
                return $this->redirect(['action' => 'manageTypes']);
            }
            $this->Flash->error(__('Unable to add vehicle type.'));
        }
        
        $this->set(compact('type'));
    }

    /**
     * Manage Manufacturers
     */
    public function manageManufacturers()
    {
        $manufacturers = $this->VehicleManufacturers->find('all')->order(['name' => 'ASC']);
        $this->set(compact('manufacturers'));
    }

    /**
     * Add Manufacturer
     */
    public function addManufacturer()
    {
        $manufacturer = $this->VehicleManufacturers->newEntity();
        
        if ($this->request->is('post')) {
            $manufacturer = $this->VehicleManufacturers->patchEntity($manufacturer, $this->request->getData());
            if ($this->VehicleManufacturers->save($manufacturer)) {
                $this->Flash->success(__('Manufacturer has been added.'));
                return $this->redirect(['action' => 'manageManufacturers']);
            }
            $this->Flash->error(__('Unable to add manufacturer.'));
        }
        
        $this->set(compact('manufacturer'));
    }

    /**
     * Manage Vehicle Models
     */
    public function manageModels()
    {
        $models = $this->VehicleModels->find('all')
            ->contain(['VehicleManufacturers', 'VehicleTypes'])
            ->order(['VehicleManufacturers.name' => 'ASC', 'model_name' => 'ASC']);
            
        $this->set(compact('models'));
    }

    /**
     * Add Vehicle Model
     */
    public function addModel()
    {
        $model = $this->VehicleModels->newEntity();
        
        if ($this->request->is('post')) {
            $model = $this->VehicleModels->patchEntity($model, $this->request->getData());
            if ($this->VehicleModels->save($model)) {
                $this->Flash->success(__('Vehicle model has been added.'));
                return $this->redirect(['action' => 'manageModels']);
            }
            $this->Flash->error(__('Unable to add vehicle model.'));
        }
        
        $manufacturers = $this->VehicleManufacturers->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order(['name' => 'ASC']);
        
        $vehicleTypes = $this->VehicleTypes->find('list', [
            'keyField' => 'id', 
            'valueField' => 'type_name'
        ])->order(['type_name' => 'ASC']);
        
        $this->set(compact('model', 'manufacturers', 'vehicleTypes'));
    }

    /**
     * Bulk import vehicle models from CSV
     */
    public function importModels()
    {
        if ($this->request->is('post') && !empty($this->request->getData('csv_file'))) {
            $file = $this->request->getData('csv_file');
            
            if ($file->getError() === UPLOAD_ERR_OK) {
                $csvData = file_get_contents($file->getStream()->getMetadata('uri'));
                $lines = explode("\n", $csvData);
                $header = str_getcsv(array_shift($lines));
                
                $imported = 0;
                $errors = [];
                
                foreach ($lines as $line) {
                    if (trim($line)) {
                        $data = str_getcsv($line);
                        $row = array_combine($header, $data);
                        
                        $model = $this->VehicleModels->newEntity();
                        $model = $this->VehicleModels->patchEntity($model, $row);
                        
                        if ($this->VehicleModels->save($model)) {
                            $imported++;
                        } else {
                            $errors[] = "Row: " . implode(', ', $data) . " - " . json_encode($model->getErrors());
                        }
                    }
                }
                
                $this->Flash->success(__('Imported {0} vehicle models successfully.', $imported));
                if (!empty($errors)) {
                    $this->Flash->error(__('Errors: {0}', implode('; ', $errors)));
                }
                
                return $this->redirect(['action' => 'manageModels']);
            }
        }
    }
}