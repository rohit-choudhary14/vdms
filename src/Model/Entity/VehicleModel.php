<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class VehicleModel extends Entity
{
    protected $_accessible = [
        'manufacturer_id' => true,
        'vehicle_type_id' => true,
        'model_name' => true,
        'seating_capacity' => true,
        'fuel_type' => true,
        'created' => true,
        'modified' => true,
        'manufacturer' => true,
        'vehicle_type' => true,
        'model_years' => true,
        'vehicles' => true,
    ];
}