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
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('InsuranceCompanies', [
            'foreignKey' => 'insurance_company_id',
            'joinType' => 'LEFT',
            'propertyName' => 'insurance_company'
        ]);
    }

     public function validationDefault(Validator $validator)
    {
        
        $validator
            ->notEmptyString('vehicle_code', 'Please select a vehicle')
            ->notEmptyString('insurance_company_id', 'Please select an insurance company');

        $validator
    ->notEmpty('policy_no', 'Policy number is required')
    ->add('policy_no', 'validPolicy', [
        'rule' => function ($value) {
            return preg_match('/^[A-Z0-9\/-]{8,20}$/', strtoupper($value)) === 1;
        },
        'message' => 'Policy number must be 8–20 characters (A-Z, 0-9, - , / only)'
    ]);

        $validator
            ->notEmptyString('nature', 'Please select policy nature')
            ->add('nature', 'validNature', [
                'rule' => function ($value) {
                    return in_array($value, [
                        'Comprehensive',
                        'Third Party',
                        'Comprehensive+Third Party'
                    ]);
                },
                'message' => 'Invalid policy nature selected'
            ]);
        $validator
            ->notEmptyDate('start_date', 'Start date is required');
            $validator
            ->notEmptyDate('expiry_date', 'Expiry date is required');
            $validator
            ->notEmptyDate('next_due', 'Next due date is required');
        
        $validator
            ->notEmptyString('premium_amount', 'Premium amount required')
            ->add('premium_amount', 'validNumber', [
                'rule' => function ($value) {
                    return is_numeric($value) && $value > 0;
                },
                'message' => 'Premium amount must be a positive number'
            ]);
      $validator
    ->notEmpty('addons', 'Please select at least one addon.')

    ->add('addons', 'validAddons', [
        'rule' => function ($value) {
            if (!is_array($value)) return false;

            $allowed = [
                'zero_depreciation',
                'engine_protection',
                'roadside_assistance',
                'return_to_invoice',
                'key_replacement',
                'consumables',
                'ncb_protection',
                'personal_accident'
            ];

            foreach ($value as $item) {
                if (!in_array($item, $allowed)) return false;
            }
            return true;
        },
        'message' => 'Invalid addon selected'
    ]);

      $validator->add('document', 'validFile', [
    'rule' => function ($value) {

        // 0. If no file uploaded → allow empty (or change to false to make it required)
        if (empty($value) || empty($value['tmp_name']) || $value['error'] === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        // 1. Max size check (5 MB)
        if ($value['size'] > 5 * 1024 * 1024) {
            return false;
        }

        // 2. Check MIME type using PHP finfo (real file type)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $value['tmp_name']);
        finfo_close($finfo);

        if ($mime !== 'application/pdf') {
            return false; // Fake PDFs caught here
        }

        // 3. Verify PDF magic number / file header
        $fh = fopen($value['tmp_name'], 'rb');
        if (!$fh) return false;

        $header = fread($fh, 5); // first 5 bytes
        fclose($fh);

        // Real PDF always starts with "%PDF-"
        if (strpos($header, '%PDF-') !== 0) {
            return false;
        }

        // 4. Optional: basic corruption check (must contain EOF marker)
        $contents = file_get_contents($value['tmp_name']);
        if (strpos($contents, '%%EOF') === false) {
            return false;
        }

        return true;
    },
    'message' => 'Invalid file! Only real, non-corrupted PDF documents under 5 MB are allowed.'
]);

        return $validator;
    }
}
