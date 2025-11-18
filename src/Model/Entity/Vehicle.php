<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vehicle Entity
 *
 * @property int $id
 * @property string $vehicle_code
 * @property string $registration_no
 * @property int|null $vehicle_type_id
 * @property int|null $manufacturer_id
 * @property int|null $model_id
 * @property int|null $model_year
 * @property string $fuel_type
 * @property int $seating_capacity
 * @property string $status
 * @property \Cake\I18n\FrozenDate $purchase_date
 * @property float $purchase_value
 * @property string $vendor
 * @property string|null $registration_doc
 * @property string|null $bill_doc
 * @property string|null $photo_front
 * @property string|null $photo_back
 * @property string $vehicle_condition
 * @property int|null $odometer_reading
 * @property \Cake\I18n\FrozenDate|null $last_service_date
 * @property string|null $keys_available
 * @property string $insurance_policy_no
 * @property \Cake\I18n\FrozenDate $insurance_expiry_date
 * @property string|null $condition_photo_front_left
 * @property string|null $condition_photo_front_right
 * @property string|null $condition_photo_back_left
 * @property string|null $condition_photo_back_right
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\VehicleType $vehicle_type
 * @property \App\Model\Entity\VehicleManufacturer $vehicle_manufacturer
 * @property \App\Model\Entity\VehicleModel $vehicle_model
 * @property \App\Model\Entity\Insurance[] $insurance
 * @property \App\Model\Entity\DriverAssignment[] $driver_assignments
 */
class Vehicle extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'vehicle_code' => true,
        'registration_no' => true,
        'vehicle_type_id' => true,
        'manufacturer_id' => true,
        'chassis_no' => true,   // or 'chassis_no' if that’s your column
        'engine_no' => true,
        'model_id' => true,
        'model_year' => true,
        'fuel_type' => true,
        'seating_capacity' => true,
        'status' => true,
        'purchase_date' => true,
        'purchase_value' => true,
        'vendor' => true,
        'registration_doc' => true,
        'bill_doc' => true,
        'photo_front' => true,
        'photo_back' => true,
        'vehicle_condition' => true,
        'odometer_reading' => true,
        'last_service_date' => true,
        'keys_available' => true,
        'insurance_policy_no' => true,
        'insurance_expiry_date' => true,
        'condition_photo_front_left' => true,
        'condition_photo_front_right' => true,
        'condition_photo_back_left' => true,
        'condition_photo_back_right' => true,
        'created' => true,
        'modified' => true,
        'vehicle_type' => true,
        'vehicle_manufacturer' => true,
        'vehicle_model' => true,
        'insurance' => true,
        'driver_assignments' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [];
}
