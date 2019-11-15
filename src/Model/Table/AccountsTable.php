<?php
// src/Model/Table/AccountsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class AccountsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('accounts');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');
        $this->hasMany('Transactions', [
            'foreignKey' => 'account_id'
        ]);
    }
}
