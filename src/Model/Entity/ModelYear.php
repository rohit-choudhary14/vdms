<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class ModelYear extends Entity
{
    protected $_accessible = [
        'model_id' => true,
        'year' => true,
        'is_available' => true,
        'created' => true,
        'modified' => true,
        'vehicle_model' => true,
    ];
}