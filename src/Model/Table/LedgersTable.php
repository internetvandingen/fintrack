<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LedgersTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('ledgers');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users');
        $this->hasMany('Transactions', [
            'foreignKey' => 'ledger_id'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Please fill this field')
            ->lengthBetween('name', [3, 20], 'Name must be between 3 and 20 characters long');
        $validator
            ->integer('balance')
            ->requirePresence('balance', 'create');
        return $validator;
    }
}
