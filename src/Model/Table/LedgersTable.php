<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LedgersTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('ledgers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Please fill this field')
            ->lengthBetween('name', [3, 15], 'Name must be between 3 and 15 characters long');
        $validator
            ->integer('balance')
            ->requirePresence('balance', 'create');
        return $validator;
    }
}
