<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Account extends Entity
{
    protected $_accessible = [
        '*' => true,
        'account_id' => false,
        'user_id' => false,
    ];
}
