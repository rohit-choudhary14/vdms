<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DriversTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('drivers');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('DriverAssignments', ['foreignKey' => 'driver_id']);
        $this->hasMany('FuelLogs', ['foreignKey' => 'driver_id']);
    }

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('name')->notEmpty('name','Driver name required');
        $validator->allowEmpty('contact_no');
        return $validator;
    }
}
