<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InsuranceCompany Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $address
 * @property string|null $website
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class InsuranceCompany extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'contact_number' => true,
        'email' => true,
        'address' => true,
        'website' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
    ];
}
