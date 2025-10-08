<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehicleModelsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('vehicle_models');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        // Associations
        $this->belongsTo('VehicleManufacturers', [
            'foreignKey' => 'manufacturer_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('VehicleTypes', [
            'foreignKey' => 'vehicle_type_id', 
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ModelYears', [
            'foreignKey' => 'model_id'
        ]);
        
        $this->hasMany('Vehicles', [
            'foreignKey' => 'model_id'
        ]);
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
            
        $validator
            ->integer('manufacturer_id')
            ->requirePresence('manufacturer_id', 'create')
            ->notEmptyString('manufacturer_id');
            
        $validator
            ->integer('vehicle_type_id')
            ->requirePresence('vehicle_type_id', 'create')
            ->notEmptyString('vehicle_type_id');
            
        $validator
            ->scalar('model_name')
            ->maxLength('model_name', 100)
            ->requirePresence('model_name', 'create')
            ->notEmptyString('model_name');
            
        $validator
            ->integer('seating_capacity')
            ->requirePresence('seating_capacity', 'create')
            ->notEmptyString('seating_capacity')
            ->range('seating_capacity', [1, 100]);
            
        $validator
            ->scalar('fuel_type')
            ->maxLength('fuel_type', 20)
            ->requirePresence('fuel_type', 'create')
            ->notEmptyString('fuel_type');
            
        return $validator;
    }
    
    /**
     * Get models by manufacturer
     */
    public function findByManufacturer($manufacturerId)
    {
        return $this->find()
            ->where(['manufacturer_id' => $manufacturerId])
            ->contain(['VehicleTypes'])
            ->order(['model_name' => 'ASC']);
    }
}