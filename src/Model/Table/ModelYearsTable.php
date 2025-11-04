<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ModelYearsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('model_years');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        // Associations
        $this->belongsTo('VehicleModels', [
            'foreignKey' => 'model_id',
            'joinType' => 'INNER'
        ]);
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
            
        $validator
            ->integer('model_id')
            ->requirePresence('model_id', 'create')
            ->notEmptyString('model_id');
            
        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year')
            ->range('year', [1990, 2030]);
            
        $validator
            ->boolean('is_available')
            ->notEmptyString('is_available');
            
        return $validator;
    }
    
    /**
     * Get available years for a specific model
     */
    public function getAvailableYears($modelId)
    {
        return $this->find()
            ->where([
                'model_id' => $modelId,
                'is_available' => true
            ])
            ->order(['year' => 'DESC'])
            ->extract('year')
            ->toArray();
    }
}
