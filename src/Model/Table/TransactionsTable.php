<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class TransactionsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }
}
