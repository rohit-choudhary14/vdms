<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InsuranceCompanies Model
 *
 * @method \App\Model\Entity\InsuranceCompany get($primaryKey, $options = [])
 * @method \App\Model\Entity\InsuranceCompany newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InsuranceCompany[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InsuranceCompany|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InsuranceCompany saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InsuranceCompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InsuranceCompany[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InsuranceCompany findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InsuranceCompaniesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('insurance_companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('contact_number')
            ->maxLength('contact_number', 15)
            ->allowEmptyString('contact_number');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('website')
            ->maxLength('website', 255)
            ->allowEmptyString('website');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
