<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\Query;

class DriverAssignmentsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('driver_assignments');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_code',
              'bindingKey' => 'driver_code',  
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_code',
             'bindingKey' => 'vehicle_code',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('driver_code')
            ->notEmptyString('driver_code', 'Driver is required');

        $validator
            ->requirePresence('vehicle_code')
            ->notEmptyString('vehicle_code', 'Vehicle is required');

        $validator
            ->requirePresence('start_date')
            ->notEmptyDate('start_date', 'Start Date is required');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        // Prevent overlapping assignments for the same driver
        $rules->add(function ($entity, $options) {
            $query = $this->find()
                ->where([
                    'driver_code' => $entity->driver_code,
                    'id !=' => $entity->id,
                    'OR' => [
                        ['end_date IS NULL'],
                        ['end_date >=' => $entity->start_date]
                    ],
                    'start_date <=' => $entity->end_date ?: $entity->start_date
                ]);
            return $query->count() === 0;
        }, 'driverOverlap', [
            'errorField' => 'driver_code',
            'message' => 'This driver already has an overlapping assignment.'
        ]);
        $rules->add(function ($entity, $options) {
            $query = $this->find()
                ->where([
                    'vehicle_code' => $entity->vehicle_code,
                    'id !=' => $entity->id,
                    'OR' => [
                        ['end_date IS NULL'],
                        ['end_date >=' => $entity->start_date]
                    ],
                    'start_date <=' => $entity->end_date ?: $entity->start_date
                ]);
            return $query->count() === 0;
        }, 'vehicleOverlap', [
            'errorField' => 'vehicle_code',
            'message' => 'This vehicle already has an overlapping assignment.'
        ]);

        return $rules;
    }
}
