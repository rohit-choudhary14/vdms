<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehicleManufacturersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('vehicle_manufacturers');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        // Associations
        $this->hasMany('VehicleModels', [
            'foreignKey' => 'manufacturer_id'
        ]);
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
            
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
            
        $validator
            ->scalar('country')
            ->maxLength('country', 50)
            ->requirePresence('country', 'create')
            ->notEmptyString('country');
            
        return $validator;
    }
}