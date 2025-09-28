<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FuelLogsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('fuel_logs');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Vehicles');
        $this->belongsTo('Drivers');
    }

    public function validationDefault(Validator $validator)
    {
        $validator->numeric('fuel_qty')->allowEmpty('fuel_qty');
        return $validator;
    }
}
