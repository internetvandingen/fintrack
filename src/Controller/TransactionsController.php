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
        // get associated transactions
        $transactions = $this->Transactions->find()->where(['account_id IN' => $accounts]);
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
        $this->set('transaction', $transaction);
    }

    public function view($id = null)
    {
        $transaction = $this->Transactions->findById($id)->firstOrFail();
        $this->set('transaction', $transaction);
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
        $this->set('transaction', $transaction);
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

    public function isAuthorized($user)
    {
        if ($user['id'] === 1){
             return true;
        }

        $action = $this->request->getParam('action');
        if (in_array($action, ['index', 'add'])) {
            // index and add are always allowed for logged in users
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
