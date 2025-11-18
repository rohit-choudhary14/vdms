<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class MaintenanceTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('maintenance');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
                'bindingKey' => 'vehicle_code',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('vehicle_code')
            ->notEmptyString('vehicle_code', 'Vehicle is required');

        $validator
            ->requirePresence('service_date')
            ->notEmptyDate('service_date', 'Service Date is required');

        $validator
            ->requirePresence('service_type')
            ->notEmptyString('service_type', 'Service Type is required');
        $validator
            ->requirePresence('vendor')
            ->notEmptyString('vendor', 'Service vendor is required');

        return $validator;
    }
}
