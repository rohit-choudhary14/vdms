<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehiclesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('vehicles');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Maintenance', ['foreignKey' => 'vehicle_code']);
        $this->hasMany('FuelLogs', ['foreignKey' => 'vehicle_code']);
        $this->hasMany('Insurance', ['foreignKey' => 'vehicle_code']);
        $this->hasMany('DriverAssignments', ['foreignKey' => 'vehicle_code']);
    }

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('registration_no')->notEmpty('registration_no','Registration no is required');
        $validator->requirePresence('vehicle_type')->notEmpty('vehicle_type','Vichle type is required');
        $validator->requirePresence('fuel_type')->notEmpty('fuel_type','Please select fuel type');
        $validator->requirePresence('make_model')->notEmpty('make_model','Manufacturer & Model is required');
        $validator->requirePresence('purchase_date')->notEmpty('purchase_date','Purchase date is required');
        $validator->requirePresence('purchase_value')->notEmpty('purchase_value','Purchase value is required');
        $validator->requirePresence('vendor')->notEmpty('vendor','Please enter vendor name');
        $validator->requirePresence('registration_doc')->notEmpty('registration_doc','Registration document is required');
        $validator->requirePresence('bill_doc')->notEmpty('bill_doc','Billing document is required');
        $validator->requirePresence('photo_front')->notEmpty('photo_front','Vehcile front photo is required');
        $validator->requirePresence('photo_back')->notEmpty('photo_back','Vehcile back photo is required');
       
        $validator->allowEmpty('vehicle_code');
        $validator->integer('seating_capacity')->notEmpty('seating_capacity');
        
        return $validator;
    }
}
