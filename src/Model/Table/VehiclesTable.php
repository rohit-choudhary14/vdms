<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Psr\Http\Message\UploadedFileInterface;


class VehiclesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('vehicles');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Master table associations
        $this->belongsTo('VehicleTypes', [
            'foreignKey' => 'vehicle_type_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('VehicleManufacturers', [
            'foreignKey' => 'manufacturer_id',
            'joinType' => 'LEFT',
            'propertyName' => 'manufacturerAssoc'
        ]);

        $this->belongsTo('VehicleModels', [
            'foreignKey' => 'model_id',
            'joinType' => 'LEFT',
            'propertyName' => 'modelAssoc'
        ]);

        // Existing associations
        $this->hasMany('Insurance', [
            'foreignKey' => 'vehicle_code',
            'bindingKey' => 'vehicle_code'
        ]);

        $this->hasMany('DriverAssignments', [
            'foreignKey' => 'vehicle_code',
            'dependent' => true
        ]);
    }
    private function isUploaded($value): bool
{
    // // PSR-7 object (CakePHP 4.x+ typical)
    // if ($value instanceof UploadedFileInterface) {
    //     return $value->getError() === UPLOAD_ERR_OK && (int)$value->getSize() > 0;
    // }

    // Legacy CakePHP 3.x array shape
    if (is_array($value)) {
        $err  = $value['error'] ?? UPLOAD_ERR_NO_FILE;
        $size = (int)($value['size'] ?? 0);
        return $err === UPLOAD_ERR_OK && $size > 0;
    }

    return false;
}


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        // Master table foreign keys (nullable to support legacy rows)
        $validator
            ->integer('vehicle_type_id')
            ->allowEmptyString('vehicle_type_id');

        $validator
            ->integer('manufacturer_id')
            ->allowEmptyString('manufacturer_id');

        $validator
            ->integer('model_id')
            ->allowEmptyString('model_id');

        // Model year
        $validator
            ->integer('model_year')
            ->allowEmptyString('model_year');

        $validator->add('model_year', 'validRange', [
            'rule' => ['range', 1990, 2030],
            'message' => 'Year must be between 1990 and 2030.',
            'on' => function ($context) {
                return !empty($context['data']['model_year']);
            }
        ]);

        // Registration
        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->requirePresence('registration_no', 'create')
            ->notEmptyString('registration_no')
            ->add('registration_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        // Vehicle code (optional)
        $validator
            ->scalar('vehicle_code')
            ->maxLength('vehicle_code', 50)
            ->allowEmptyString('vehicle_code');

        // Newly added fields
        $validator
            ->scalar('chassis_no')
            ->maxLength('chassis_no', 64)
            ->requirePresence('chassis_no', 'create')
            ->notEmptyString('chassis_no');

        $validator
            ->scalar('engine_no')
            ->maxLength('engine_no', 64)
            ->requirePresence('engine_no', 'create')
            ->notEmptyString('engine_no');

        // Fuel / seating / status
        $validator
            ->scalar('fuel_type')
            ->maxLength('fuel_type', 20)
            ->requirePresence('fuel_type', 'create')
            ->notEmptyString('fuel_type');

        $validator
            ->integer('seating_capacity')
            ->requirePresence('seating_capacity', 'create')
            ->notEmptyString('seating_capacity')
            ->range('seating_capacity', [1, 100]);

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        // Purchase details
        $validator
            ->date('purchase_date')
            ->requirePresence('purchase_date', 'create')
            ->notEmptyDate('purchase_date');

        $validator
            ->decimal('purchase_value')
            ->requirePresence('purchase_value', 'create')
            ->notEmptyString('purchase_value');

        $validator
            ->scalar('vendor')
            ->maxLength('vendor', 100)
            ->requirePresence('vendor', 'create')
            ->notEmptyString('vendor');

        // Vehicle condition (drives dynamic fields)
        $validator
            ->scalar('vehicle_condition')
            ->requirePresence('vehicle_condition', 'create')
            ->notEmptyString('vehicle_condition')
            ->inList('vehicle_condition', ['newly_purchased', 'already_existed'], 'Select a valid vehicle condition.');

        // Already existed specific fields (conditional requirements)
        $validator
            ->integer('odometer_reading')
            ->allowEmptyString('odometer_reading', null, function ($context) {
                return empty($context['data']['vehicle_condition']) ||
                       $context['data']['vehicle_condition'] !== 'already_existed';
            })
            ->requirePresence('odometer_reading', function ($context) {
                return !empty($context['data']['vehicle_condition']) &&
                       $context['data']['vehicle_condition'] === 'already_existed';
            });

        $validator
            ->date('last_service_date')
            ->allowEmptyDate('last_service_date', null, function ($context) {
                return empty($context['data']['vehicle_condition']) ||
                       $context['data']['vehicle_condition'] !== 'already_existed';
            });

        $validator
            ->scalar('keys_available')
            ->allowEmptyString('keys_available', null, function ($context) {
                return empty($context['data']['vehicle_condition']) ||
                       $context['data']['vehicle_condition'] !== 'already_existed';
            })
            ->inList('keys_available', ['1_key', '2_keys'], 'Invalid key option.', 'default', function ($context) {
                return !empty($context['data']['keys_available']);
            });

        // Insurance
        $validator
            ->scalar('insurance_policy_no')
            ->maxLength('insurance_policy_no', 100)
            ->requirePresence('insurance_policy_no', 'create')
            ->notEmptyString('insurance_policy_no');

        $validator
            ->date('insurance_expiry_date')
            ->requirePresence('insurance_expiry_date', 'create')
            ->notEmptyDate('insurance_expiry_date');

        // ===== Cross-field date rules vs model_year =====
        // purchase_date not before 1 Jan of model_year
        $validator->add('purchase_date', 'notBeforeModelYear', [
            'rule' => function ($value, $context) {
                if (empty($context['data']['model_year']) || empty($value)) {
                    return true;
                }
                $year = (int)$context['data']['model_year'];
                $min  = new \DateTime("$year-01-01");
                $d    = ($value instanceof \DateTimeInterface) ? $value : new \DateTime($value);
                return $d >= $min;
            },
            'message' => 'Purchase Date cannot be before the selected Model Year.'
        ]);

        // insurance_expiry_date not before model_year and not before purchase_date
        $validator->add('insurance_expiry_date', 'notBeforeModelYear', [
            'rule' => function ($value, $context) {
                if (empty($context['data']['model_year']) || empty($value)) {
                    return true;
                }
                $year = (int)$context['data']['model_year'];
                $min  = new \DateTime("$year-01-01");
                $d    = ($value instanceof \DateTimeInterface) ? $value : new \DateTime($value);
                return $d >= $min;
            },
            'message' => 'Insurance Expiry Date cannot be before the selected Model Year.'
        ])->add('insurance_expiry_date', 'notBeforePurchase', [
            'rule' => function ($value, $context) {
                if (empty($context['data']['purchase_date']) || empty($value)) {
                    return true;
                }
                $p = ($context['data']['purchase_date'] instanceof \DateTimeInterface)
                    ? $context['data']['purchase_date']
                    : new \DateTime($context['data']['purchase_date']);
                $i = ($value instanceof \DateTimeInterface) ? $value : new \DateTime($value);
                return $i >= $p;
            },
            'message' => 'Insurance Expiry Date cannot be before Purchase Date.'
        ]);

        // // ===== File validations =====
        // // PDFs: registration_doc, bill_doc (<= 5MB)
        // $validator->allowEmptyFile('registration_doc');
        // $validator->add('registration_doc', 'mimeType', [
        //     'rule' => ['mimeType', ['application/pdf']],
        //     'message' => 'Registration Document must be a PDF.'
        // ])->add('registration_doc', 'fileSize', [
        //     'rule' => ['fileSize', '<=', '5MB'],
        //     'message' => 'Registration Document must be 5MB or smaller.'
        // ]);

        // $validator->allowEmptyFile('bill_doc');
        // $validator->add('bill_doc', 'mimeType', [
        //     'rule' => ['mimeType', ['application/pdf']],
        //     'message' => 'Bill Document must be a PDF.'
        // ])->add('bill_doc', 'fileSize', [
        //     'rule' => ['fileSize', '<=', '5MB'],
        //     'message' => 'Bill Document must be 5MB or smaller.'
        // ]);

        // // Images: only JPG/JPEG, <= 2MB
        // foreach (['photo_front','photo_back','condition_photo_front_left','condition_photo_front_right','condition_photo_back_left','condition_photo_back_right'] as $imgField) {
        //     $validator->allowEmptyFile($imgField);
        //     $validator->add($imgField, 'mimeType', [
        //         'rule' => ['mimeType', ['image/jpeg']],
        //         'message' => 'Only JPG/JPEG images are allowed.'
        //     ])->add($imgField, 'fileSize', [
        //         'rule' => ['fileSize', '<=', '2MB'],
        //         'message' => 'Image must be 2MB or smaller.'
        //     ]);
        // }

        // ----- Files: PDFs (<=5MB) -----
$validator->allowEmptyFile('registration_doc');
$validator
    ->add('registration_doc', 'pdfType', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $type = $value instanceof UploadedFileInterface
                ? $value->getClientMediaType()
                : ($value['type'] ?? '');
            return in_array($type, ['application/pdf'], true);
        },
        'message' => 'Registration Document must be a PDF.',
        'on' => function ($context) {
            return $this->isUploaded($context['data']['registration_doc'] ?? null);
        }
    ])
    ->add('registration_doc', 'pdfSize', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $size = $value instanceof UploadedFileInterface
                ? (int)$value->getSize()
                : (int)($value['size'] ?? 0);
            return $size <= 5 * 1024 * 1024; // 5MB
        },
        'message' => 'Registration Document must be 5MB or smaller.',
        'on' => function ($context) {
            return $this->isUploaded($context['data']['registration_doc'] ?? null);
        }
    ]);

// Bill PDF
$validator->allowEmptyFile('bill_doc');
$validator
    ->add('bill_doc', 'pdfType', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $type = $value instanceof UploadedFileInterface
                ? $value->getClientMediaType()
                : ($value['type'] ?? '');
            return in_array($type, ['application/pdf'], true);
        },
        'message' => 'Bill Document must be a PDF.',
        'on' => function ($context) {
            return $this->isUploaded($context['data']['bill_doc'] ?? null);
        }
    ])
    ->add('bill_doc', 'pdfSize', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $size = $value instanceof UploadedFileInterface
                ? (int)$value->getSize()
                : (int)($value['size'] ?? 0);
            return $size <= 5 * 1024 * 1024; // 5MB
        },
        'message' => 'Bill Document must be 5MB or smaller.',
        'on' => function ($context) {
            return $this->isUploaded($context['data']['bill_doc'] ?? null);
        }
    ]);

// ----- Images: JPG/JPEG only, <=5MB -----
foreach ([
    'photo_front','photo_back',
    'condition_photo_front_left','condition_photo_front_right',
    'condition_photo_back_left','condition_photo_back_right'
] as $imgField) {

    $validator->allowEmptyFile($imgField);

    $validator->add($imgField, 'jpgType', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $type = $value instanceof UploadedFileInterface
                ? $value->getClientMediaType()
                : ($value['type'] ?? '');
            // Accept common JPEG mime types
            return in_array($type, ['image/jpeg', 'image/pjpeg', 'image/jpg'], true);
        },
        'message' => 'Only JPG/JPEG images are allowed.',
        'on' => function ($context) use ($imgField) {
            return $this->isUploaded($context['data'][$imgField] ?? null);
        }
    ])->add($imgField, 'jpgSize', [
        'rule' => function ($value, $context) {
            if (!$this->isUploaded($value)) return true;
            $size = $value instanceof UploadedFileInterface
                ? (int)$value->getSize()
                : (int)($value['size'] ?? 0);
            return $size <= 5 * 1024 * 1024; // 5MB
        },
        'message' => 'Image must be 5MB or smaller.',
        'on' => function ($context) use ($imgField) {
            return $this->isUploaded($context['data'][$imgField] ?? null);
        }
    ]);
}

       return $validator;
    }

    /**
     * Build rules for validation
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['registration_no']), [
            'errorField' => 'registration_no',
            'message' => 'This registration number is already registered.'
        ]);

        $rules->add($rules->existsIn(['vehicle_type_id'], 'VehicleTypes'), [
            'errorField' => 'vehicle_type_id',
            'message' => 'Please select a valid vehicle type.'
        ]);

        $rules->add($rules->existsIn(['manufacturer_id'], 'VehicleManufacturers'), [
            'errorField' => 'manufacturer_id',
            'message' => 'Please select a valid manufacturer.'
        ]);

        $rules->add($rules->existsIn(['model_id'], 'VehicleModels'), [
            'errorField' => 'model_id',
            'message' => 'Please select a valid vehicle model.'
        ]);

        return $rules;
    }
}
