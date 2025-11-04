<?php
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

        // Vehicle relationship
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code',
            'joinType' => 'INNER'
        ]);

        // Link to Insurance Companies Master
        $this->belongsTo('InsuranceCompanies', [
            'foreignKey' => 'insurance_company_id',
            'joinType' => 'LEFT',
            'propertyName' => 'insurance_company'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
       $validator
            ->notEmptyString('policy_no', 'Policy no required')
            ->notEmptyString('vehicle_id', 'Please select vehicle id')
            ->notEmptyString('nature', 'Please select nature of policy')
            ->notEmpty('vehicle_code', 'Please select an vechical')
            ->notEmpty('insurance_company_id', 'Please select an insurance company')
            ->notEmptyFile('document', 'Please upload insurance document')
            ->notEmptyDate('start_date', 'Insurance start date is required')
            ->notEmptyDate('expiry_date', 'Insurance end date is required')
            ->notEmptyDate('next_due', 'Insurance next due date is required')
         
            ->greaterThan('premium_amount', 0, 'Premium amount must be greater than 0.');


        return $validator;
    }
}
