<?php

namespace App\Controller;

use App\Controller\AppController;

class TransactionsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadModel('Accounts');
    }

    public function all()
    {
        $this->loadComponent('Paginator');
        $transactions = $this->Paginator->paginate($this->Transactions);
        $this->set(compact('transactions'));
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $logged_id = $this->Auth->user('id');
        // get a list of account id's
        $accounts = $this->Accounts->find()->where(['user_id' => $logged_id])->extract('id')->toList();
        if(empty($accounts)){
            // no accounts found with user, this also means no transactions, so search for impossible condition
            $accounts = [-1];
        }
        // get associated transactions
        $transactions = $this->Transactions->find()->where(['account_id IN' => $accounts])->contain(['Accounts', 'Ledgers']);
        $transactions = $this->Paginator->paginate($transactions);
        $this->set(compact('transactions'));
        $this->set('_serialize', ['transactions']);
    }

    public function add()
    {
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());

            $transaction->user_id = $this->Auth->user('id');

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('Your new transaction has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add transaction.'));
        }

        $this->loadModel('Ledgers');
        $transaction->ledger_options = $this->Ledgers->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
        $transaction->account_options = $this->Accounts->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();

        $this->set('transaction', $transaction);
    }

    public function upload()
    {
        $this->loadModel('Ledgers');
        $ledger_options = $this->Ledgers->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
        $temp_ledger_id = array_search('Temporary', $ledger_options);

        $accounts = $this->Accounts->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
        $data = $this->request->getData();
        if ($this->request->is('post')) {
            // parse data
            $parsed = $this->Transactions->parse($data['transactions'], $data['bank'], $data['account_id'], $temp_ledger_id);
            if ($parsed){
                $entities = $this->Transactions->newEntities($parsed);
                $result = $this->Transactions->saveMany($entities);
                if ($result){
                    $this->Flash->success(__('New transactions succesfully saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('Unable to add transactions.'));
        }
        $this->set('accounts', $accounts);
    }

    public function view($id = null)
    {
        $transaction = $this->Transactions->findById($id)->contain(['Accounts', 'Ledgers'])->firstOrFail();
        $this->set('transaction', $transaction);
        $this->set('id', $id);
    }

    public function edit($id)
    {
        $transaction = $this->Transactions->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Transactions->patchEntity($transaction, $this->request->getData(), ['accessibleFields' => ['user_id' => false]]);
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update the transaction.'));
        }

        $this->loadModel('Ledgers');
        $user_id = $this->Accounts->get($transaction->account_id)->user_id;
        $transaction->ledger_options = $this->Ledgers->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();

        $this->set('transaction', $transaction);
        $this->set('id', $id);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function assign()
    {
        $this->loadModel('Ledgers');
        $ledger_options = $this->Ledgers->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
        $temp_ledger_id = array_search('Temporary', $ledger_options);

        // see overview of accounts and a count of how many unassigned transactions they have
        // show a list of transactions that have unassigned ledgers for each account
        $accounts = $this->Accounts->findByUser_id($this->Auth->user('id'))
                         ->contain(['Transactions' => function ($q) use ($temp_ledger_id) {
                                        return $q->where(['Transactions.ledger_id' => strval($temp_ledger_id)]);
                                   }
                                   ]);


        // POST request of changed ledgers
        if ($this->request->is(['post', 'put'])) {
            $form_data = $this->request->getData();
            foreach ($accounts as $account){
                $original_transactions = $account['transactions'];
                if (!array_key_exists($account['id'], $form_data) || is_null($form_data[$account['id']])){
                    continue;
                }
                $form_transactions = $form_data[$account['id']];
                $patched = $this->Transactions->patchEntities($original_transactions, $form_transactions, ['accessibleFields' => ['account_id' => false]]);
                $this->Transactions->saveMany($patched);
            }
            $this->Flash->success(__('The transactions have been updated successfully.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('accounts', $accounts);
        $this->set('ledger_options', $ledger_options);
    }

    public function overview()
    {

    }

    public function api($argument=null)
    {
        $year = date("Y");
        if (!is_null($argument)){
            $year = $argument;
        }

        $this->loadModel('Ledgers');

        // find account id's of user
        $logged_id = $this->Auth->user('id');
        $accounts = $this->Accounts->find()->where(['user_id' => $logged_id])->extract('id')->toList();
        if(empty($accounts)){
            // no accounts found with user, this also means no transactions, so search for impossible condition
            $accounts = [-1];
        }
        // create string containing all account id's to insert into query
        $accounts = "(" . implode(", ", $accounts) . ")";

        $sql = "SELECT l.name, l.color, MONTH(t.date) AS month, SUM(t.amount)/100 as amount, t.account_id ".
               "FROM transactions t ".
               "LEFT JOIN ledgers l ON t.ledger_id = l.id ".
               "WHERE t.account_id IN " . $accounts . " AND t.date BETWEEN '".$year."-01-01' AND '".$year."-12-31' ".
               "GROUP BY l.id, month";
        $data = $this->Transactions->getConnection()->execute($sql)->fetchAll('assoc');

        $this->set([
            'data' => $data,
            '_serialize' => 'data',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    public function isAuthorized($user)
    {
        if ($user['id'] === 9){
             return true;
        }

        $action = $this->request->getParam('action');
        if (in_array($action, ['index', 'add', 'upload', 'assign', 'overview', 'api'])) {
            // These actions are always allowed for logged in users
            return true;
        } else if (in_array($action, ['view', 'edit', 'delete'])){
            // require id
            $id = $this->request->getParam('pass.0');
            if (!$id) {
                return false;
            }
            $logged_id = $this->Auth->user('id');
            $account_id = $this->Transactions->get($id)->account_id;
            $user_id = $this->Accounts->get($account_id)->user_id;
            if ($logged_id === $user_id){
                return true;
            }
        }

        return false;
    }

}
