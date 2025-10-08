<?php

namespace App\Model\Entity;
use Cake\ORM\Entity;

class VehicleType extends Entity
{
    protected $_accessible = [
        'type_name' => true,
        'category' => true,
        'created' => true,
        'modified' => true,
        'vehicle_models' => true,
    ];
}