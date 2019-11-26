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
        $this->belongsTo('Accounts');
        $this->belongsTo('Ledgers');
    }

    public function parse($transactions, $bank, $account_id)
    {
        switch ($bank) {
            case "ING":
                $parsed = [];
                foreach ($transactions as $i => $entry){
                    $parsed[$i] = [];
                    $parsed[$i] = [
                                   'account_id' => $account_id,
                                   'amount' => ($entry['Af Bij']=='Af' ? '-' : '' ) . str_replace(',', '', $entry['Bedrag (EUR)']),
                                   'counter_account' => $entry['Tegenrekening'],
                                   'date' => substr($entry['Datum'], 0,4) . '-' . substr($entry['Datum'], 4, 2) . '-' . substr($entry['Datum'],   6,2),
                                   'ledger_id' => 0,
                                   'description' => $entry['Naam / Omschrijving'] . ' ' . $entry['MutatieSoort'] . ' ' . $entry['Mededelingen']
                                   ];
                }
                break;
            default:
                $parsed = false;
                break;
        }
        return $parsed;
    }

}
