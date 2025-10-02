<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Accident extends Entity
{
    protected $_accessible = [
        '*' => true,
        'accident_id' => false, // protect PK
    ];
}
