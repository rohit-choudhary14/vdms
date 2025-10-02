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
            'foreignKey' => 'driver_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('driver_id')
            ->notEmptyString('driver_id', 'Driver is required');

        $validator
            ->requirePresence('vehicle_id')
            ->notEmptyString('vehicle_id', 'Vehicle is required');

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
                    'driver_id' => $entity->driver_id,
                    'id !=' => $entity->id,
                    'OR' => [
                        ['end_date IS NULL'],
                        ['end_date >=' => $entity->start_date]
                    ],
                    'start_date <=' => $entity->end_date ?: $entity->start_date
                ]);
            return $query->count() === 0;
        }, 'driverOverlap', [
            'errorField' => 'driver_id',
            'message' => 'This driver already has an overlapping assignment.'
        ]);

        // Prevent overlapping assignments for the same vehicle
        $rules->add(function ($entity, $options) {
            $query = $this->find()
                ->where([
                    'vehicle_id' => $entity->vehicle_id,
                    'id !=' => $entity->id,
                    'OR' => [
                        ['end_date IS NULL'],
                        ['end_date >=' => $entity->start_date]
                    ],
                    'start_date <=' => $entity->end_date ?: $entity->start_date
                ]);
            return $query->count() === 0;
        }, 'vehicleOverlap', [
            'errorField' => 'vehicle_id',
            'message' => 'This vehicle already has an overlapping assignment.'
        ]);

        return $rules;
    }
}
