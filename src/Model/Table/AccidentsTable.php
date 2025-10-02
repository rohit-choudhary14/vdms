<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AccidentsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('accidents');
        $this->setPrimaryKey('accident_id');

        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code',   // since FK is vehicle_code
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_code',
            'bindingKey' => 'driver_code',   // since FK is driver_code
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmptyString('vehicle_code', 'Vehicle is required')
            ->notEmptyString('driver_code', 'Driver is required')
            ->notEmptyDateTime('date_time', 'Date & Time is required')
            ->notEmptyString('location', 'Location is required')
            ->notEmptyString('nature_of_accident', 'Nature of accident is required')
            ->notEmptyString('insurance_claim_status', 'Insurance claim status is required');

        return $validator;
    }
}
