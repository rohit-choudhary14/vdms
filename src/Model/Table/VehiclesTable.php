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

        $this->hasMany('Maintenance', ['foreignKey' => 'vehicle_id']);
        $this->hasMany('FuelLogs', ['foreignKey' => 'vehicle_id']);
        $this->hasMany('Insurance', ['foreignKey' => 'vehicle_id']);
        $this->hasMany('DriverAssignments', ['foreignKey' => 'vehicle_id']);
    }

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('registration_no')->notEmpty('registration_no','Registration no is required');
        $validator->allowEmpty('vehicle_code');
        $validator->integer('seating_capacity')->allowEmpty('seating_capacity');
        return $validator;
    }
}
