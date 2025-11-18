<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehicleTypesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('vehicle_types');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        // Associations
        $this->hasMany('VehicleModels', [
            'foreignKey' => 'vehicle_type_id'
        ]);
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
            
        $validator
            ->scalar('type_name')
            ->maxLength('type_name', 50)
            ->requirePresence('type_name', 'create')
            ->notEmptyString('type_name')
            ->add('type_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
            
        $validator
            ->scalar('category')
            ->maxLength('category', 50)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');
            
        return $validator;
    }
}