<?php

namespace App\Controller;

use App\Controller\AppController;

class TransactionsController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $transactions = $this->Paginator->paginate($this->Transactions);
        $this->set(compact('transactions'));
    }

    public function view($id = null)
    {
        $transaction = $this->Transactions->findById($id)->firstOrFail();
        $this->set('transaction', $transaction);
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
        $action = $this->request->getParam('action');
        // The add action is always allowed to logged in users.
        if (in_array($action, ['add'])) {
            return true;
        }
    
        // All other actions require an id.
        $id = $this->request->getParam('pass.0');
        if (!$id) {
            return false;
        }
    
        // Check that the transaction belongs to the current user.
        $transaction = $this->Transactions->findById($id)->first();
        $account = $this->Accounts->findById($transaction->account_id)->first();
        return $account->user_id === $user['id'];
    }
}
