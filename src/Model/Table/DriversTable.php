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

    $this->hasMany('DriverAssignments', ['foreignKey' => 'driver_code']);
    $this->hasMany('Fuel', ['foreignKey' => 'driver_code']); // fuel logs
    $this->hasMany('Alerts', ['foreignKey' => 'driver_code']);
}

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('name')->notEmpty('name', 'Driver name required');
        $validator->requirePresence('father_name')->notEmpty('father_name', 'Driver father name required');
        $validator->requirePresence('address')->notEmpty('address', 'Address is  required');
        $validator->requirePresence('driver_photo')->notEmpty('driver_photo', 'Driver photo is  required');
        $validator->requirePresence('license_doc')->notEmpty('license_doc', 'License is  required');
        $validator->requirePresence('license_validity')->notEmpty('license_validity', 'License  validity date is  required');
        $validator->requirePresence('license_no')->notEmpty('license_no', 'License number is  required');
       
        $validator->integer('contact_no')->notEmpty('contact_no','Contact is required');
        return $validator;
    }
}
