<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FuelTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('fuel');
        $this->setPrimaryKey('fuel_id');
        $this->belongsTo(
            'Vehicles',

            [
                'foreignKey' => 'vehicle_code',
                'bindingKey' => 'vehicle_code',
                'joinType' => 'INNER'
            ]
        );
        $this->belongsTo(
            'Drivers',
            [
                'foreignKey' => 'driver_code',
                'bindingKey' => 'driver_code',
                'joinType' => 'INNER'
            ]
        );
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmptyString('vehicle_code', 'Vehicle is required')
            ->notEmptyString('driver_code', 'Driver is required')
            ->notEmptyDate('refuel_date', 'Refuel date is required')
            ->numeric('fuel_quantity', 'Fuel quantity must be numeric')
            ->greaterThan('fuel_quantity', 0, 'Fuel quantity must be greater than 0')
            ->numeric('odometer_reading', 'Odometer must be numeric')
            ->greaterThan('odometer_reading', 0, 'Odometer must be greater than 0')
            ->numeric('fuel_cost', 'Fuel cost must be numeric')       
            ->greaterThan('fuel_cost', 0, 'Fuel cost must be greater than 0'); 
            return $validator;
    }
}
