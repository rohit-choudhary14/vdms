<?php
// src/Model/Table/InsuranceTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class InsuranceTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('insurance');
        $this->setPrimaryKey('insurance_id');
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmptyString('policy_no','Policy no required')
            ->notEmptyString('vehicle_id','Please select vehicle id')
            ->notEmptyString('nature','Please select nature of  policy')
            ->notEmptyString('insurer_name','Insurer name is required')
            ->notEmptyString('insurer_contact','Insurer contact is required')
            ->notEmptyString('insurer_address','Insurer address is required')
            ->notEmptyFile('document','Please upload insurance document')
            ->notEmptyDate('start_date','Insurance start date is required')
            ->notEmptyDate('expiry_date','Insurance end date is required')
            ->notEmptyDate('next_due','Insurance next due date is required')
            ->numeric('premium_amount')->notEmpty('premium_amount','Premium amount is required');
        return $validator;
    }
}
