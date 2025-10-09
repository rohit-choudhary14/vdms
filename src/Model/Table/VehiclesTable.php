<?php
// namespace App\Model\Table;

// use Cake\ORM\Table;
// use Cake\Validation\Validator;

// class VehiclesTable extends Table
// {
//     public function initialize(array $config)
//     {
//         parent::initialize($config);
//         $this->setTable('vehicles');
//         $this->setPrimaryKey('id');
//         $this->addBehavior('Timestamp');

//         $this->hasMany('Maintenance', ['foreignKey' => 'vehicle_code']);
//         $this->hasMany('FuelLogs', ['foreignKey' => 'vehicle_code']);
//         $this->hasMany('Insurance', ['foreignKey' => 'vehicle_code',
//                                      'bindingKey' => 'vehicle_code']);
//         $this->hasMany('DriverAssignments', ['foreignKey' => 'vehicle_code']);
//     }

//     public function validationDefault(Validator $validator)
//     {
//         $validator->requirePresence('registration_no')->notEmpty('registration_no','Registration no is required');
//         $validator->requirePresence('vehicle_type')->notEmpty('vehicle_type','Vichle type is required');
//         $validator->requirePresence('fuel_type')->notEmpty('fuel_type','Please select fuel type');
//         $validator->requirePresence('make_model')->notEmpty('make_model','Manufacturer & Model is required');
//         $validator->requirePresence('purchase_date')->notEmpty('purchase_date','Purchase date is required');
//         $validator->requirePresence('purchase_value')->notEmpty('purchase_value','Purchase value is required');
//         $validator->requirePresence('vendor')->notEmpty('vendor','Please enter vendor name');
//         $validator->requirePresence('registration_doc')->notEmpty('registration_doc','Registration document is required');
//         $validator->requirePresence('bill_doc')->notEmpty('bill_doc','Billing document is required');
//         $validator->requirePresence('photo_front')->notEmpty('photo_front','Vehcile front photo is required');
//         $validator->requirePresence('photo_back')->notEmpty('photo_back','Vehcile back photo is required');
       
//         $validator->allowEmpty('vehicle_code');
//         $validator->integer('seating_capacity')->notEmpty('seating_capacity');
        
//         return $validator;
//     }
// } -->
// namespace App\Model\Table;
// use Cake\ORM\Table;
// use Cake\Validation\Validator;

// class VehiclesTable extends Table
// {
//     public function initialize(array $config): void
//     {
//         parent::initialize($config);
        
//         $this->setTable('vehicles');
//         $this->setPrimaryKey('id');
        
//         $this->addBehavior('Timestamp');
        
//         // UPDATED ASSOCIATIONS
//         $this->belongsTo('VehicleTypes', [
//             'foreignKey' => 'vehicle_type_id',
//             'joinType' => 'INNER'
//         ]);
        
//         $this->belongsTo('VehicleManufacturers', [
//             'foreignKey' => 'manufacturer_id', 
//             'joinType' => 'INNER'
//         ]);
        
//         $this->belongsTo('VehicleModels', [
//             'foreignKey' => 'model_id',
//             'joinType' => 'INNER'
//         ]);
        
//         // Keep existing associations
//         $this->hasMany('Insurance', [
//             'foreignKey' => 'vehicle_code',
//             'bindingKey' => 'vehicle_code'
//         ]);
//     }
    
//     public function validationDefault(Validator $validator): Validator
//     {
//         // Add new validations for master table fields
//         $validator
//             ->integer('vehicle_type_id')
//             ->requirePresence('vehicle_type_id', 'create')
//             ->notEmptyString('vehicle_type_id');
            
//         $validator
//             ->integer('manufacturer_id')
//             ->requirePresence('manufacturer_id', 'create')
//             ->notEmptyString('manufacturer_id');
            
//         $validator
//             ->integer('model_id')  
//             ->requirePresence('model_id', 'create')
//             ->notEmptyString('model_id');
            
//         $validator
//             ->integer('model_year')
//             ->requirePresence('model_year', 'create')
//             ->notEmptyString('model_year')
//             ->range('model_year', [1990, 2030]);
            
//         // Update status validation
//         $validator
//             ->scalar('status')
//             ->requirePresence('status', 'create')
//             ->notEmptyString('status')
//             ->inList('status', ['Alloted', 'Unalloted', 'Condemned', 'In-Garage']);
        
//         // Keep existing validations...
        
//         return $validator;
//     }
// }


namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehiclesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('vehicles');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        // NEW: Master table associations
        $this->belongsTo('VehicleTypes', [
            'foreignKey' => 'vehicle_type_id',
            'joinType' => 'LEFT'  // Changed to LEFT in case old records don't have it
        ]);
        
        $this->belongsTo('VehicleManufacturers', [
            'foreignKey' => 'manufacturer_id', 
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('VehicleModels', [
            'foreignKey' => 'model_id',
            'joinType' => 'LEFT'
        ]);
        
        // EXISTING ASSOCIATIONS - ADD THESE BACK!
        $this->hasMany('Insurance', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code'
        ]);
        
        // ADD THIS - DriverAssignments association
        $this->hasMany('DriverAssignments', [
            'foreignKey' => 'vehicle_id',  // Or 'vehicle_code' if that's the key
            'dependent' => true
        ]);
        
        // Add any other associations your app uses:
        // Examples (uncomment and adjust if you have these):
        
        // $this->hasMany('Maintenance', [
        //     'foreignKey' => 'vehicle_id'
        // ]);
        
        // $this->hasMany('FuelRecords', [
        //     'foreignKey' => 'vehicle_id'
        // ]);
        
        // $this->hasMany('Trips', [
        //     'foreignKey' => 'vehicle_id'
        // ]);
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        
        // New master table validations
        $validator
            ->integer('vehicle_type_id')
            ->allowEmptyString('vehicle_type_id');  // Allow empty for old records
            
        $validator
            ->integer('manufacturer_id')
            ->allowEmptyString('manufacturer_id');
            
        $validator
            ->integer('model_id')  
            ->allowEmptyString('model_id');
            
        $validator
            ->integer('model_year')
            ->allowEmptyString('model_year')
            ->range('model_year', [1990, 2030], 'Year must be between 1990 and 2030', 'default', function ($context) {
                return !empty($context['data']['model_year']);
            });
        
        // Existing validations
        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->requirePresence('registration_no', 'create')
            ->notEmptyString('registration_no')
            ->add('registration_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
        
        $validator
            ->scalar('vehicle_code')
            ->maxLength('vehicle_code', 50)
            ->allowEmptyString('vehicle_code');
        
        $validator
            ->scalar('fuel_type')
            ->maxLength('fuel_type', 20)
            ->requirePresence('fuel_type', 'create')
            ->notEmptyString('fuel_type');
        
        $validator
            ->integer('seating_capacity')
            ->requirePresence('seating_capacity', 'create')
            ->notEmptyString('seating_capacity')
            ->range('seating_capacity', [1, 100]);
        
        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');
        
        $validator
            ->date('purchase_date')
            ->requirePresence('purchase_date', 'create')
            ->notEmptyDate('purchase_date');
        
        $validator
            ->decimal('purchase_value')
            ->requirePresence('purchase_value', 'create')
            ->notEmptyString('purchase_value');
        
        $validator
            ->scalar('vendor')
            ->maxLength('vendor', 100)
            ->requirePresence('vendor', 'create')
            ->notEmptyString('vendor');
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['registration_no']), ['errorField' => 'registration_no']);
        
        return $rules;
    }
}
