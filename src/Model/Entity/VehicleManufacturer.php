<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class VehicleManufacturer extends Entity
{
    protected $_accessible = [
        'name' => true,
        'country' => true,
        'created' => true,
        'modified' => true,
        'vehicle_models' => true,
    ];
}