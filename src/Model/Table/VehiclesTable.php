<?php



namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker; 

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
            'joinType' => 'LEFT' ,
            'propertyName' => 'vehicleTypeAssoc'  // Changed to LEFT in case old records don't have it
        ]);
        
        $this->belongsTo('VehicleManufacturers', [
            'foreignKey' => 'manufacturer_id', 
            'joinType' => 'LEFT',
             'propertyName' => 'manufacturerAssoc' 
        ]);
        
        $this->belongsTo('VehicleModels', [
            'foreignKey' => 'model_id',
            'joinType' => 'LEFT',
            'propertyName' => 'modelAssoc' 
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
        
        // $validator
        //     ->date('purchase_date')
        //     ->requirePresence('purchase_date', 'create')
        //     ->notEmptyDate('purchase_date');
        
        $validator
            ->decimal('purchase_value')
            ->requirePresence('purchase_value', 'create')
            ->notEmptyString('purchase_value');
        
        $validator
            ->scalar('vendor')
            ->maxLength('vendor', 100)
            ->requirePresence('vendor', 'create')
            ->notEmptyString('vendor');

        //new validators for already existed vehicles
         $validator
        ->scalar('vehicle_condition')
        ->requirePresence('vehicle_condition', 'create')
        ->notEmptyString('vehicle_condition')
        ->inList('vehicle_condition', ['newly_purchased', 'already_existed']);

    $validator
        ->integer('odometer_reading')
        ->allowEmptyString('odometer_reading', null, function ($context) {
            return empty($context['data']['vehicle_condition']) || 
                   $context['data']['vehicle_condition'] !== 'already_existed';
        })
        ->requirePresence('odometer_reading', function ($context) {
            return !empty($context['data']['vehicle_condition']) && 
                   $context['data']['vehicle_condition'] === 'already_existed';
        });

    $validator
        ->date('last_service_date')
        ->allowEmptyDate('last_service_date', null, function ($context) {
            return empty($context['data']['vehicle_condition']) || 
                   $context['data']['vehicle_condition'] !== 'already_existed';
        });

    $validator
        ->scalar('keys_available')
        ->allowEmptyString('keys_available', null, function ($context) {
            return empty($context['data']['vehicle_condition']) || 
                   $context['data']['vehicle_condition'] !== 'already_existed';
        })
        ->inList('keys_available', ['1_key', '2_keys'], 'Invalid key option', 'default', function ($context) {
            return !empty($context['data']['keys_available']);
        });

    $validator
        ->scalar('insurance_policy_no')
        ->maxLength('insurance_policy_no', 100)
        ->requirePresence('insurance_policy_no', 'create')
        ->notEmptyString('insurance_policy_no');

    // $validator
    //     ->date('insurance_expiry_date')
    //     ->requirePresence('insurance_expiry_date', 'create')
    //     ->notEmptyDate('insurance_expiry_date');

    
        return $validator;
    }
    
    /**
 * Build rules for validation
 *
 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
 * @return \Cake\ORM\RulesChecker
 */
public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->isUnique(['registration_no']), [
        'errorField' => 'registration_no',
        'message' => 'This registration number is already registered.'
    ]);
    
    $rules->add($rules->existsIn(['vehicle_type_id'], 'VehicleTypes'), [
        'errorField' => 'vehicle_type_id',
        'message' => 'Please select a valid vehicle type.'
    ]);
    
    $rules->add($rules->existsIn(['manufacturer_id'], 'VehicleManufacturers'), [
        'errorField' => 'manufacturer_id',
        'message' => 'Please select a valid manufacturer.'
    ]);
    
    $rules->add($rules->existsIn(['model_id'], 'VehicleModels'), [
        'errorField' => 'model_id',
        'message' => 'Please select a valid vehicle model.'
    ]);

    return $rules;
}

}
