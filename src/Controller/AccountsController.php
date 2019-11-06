<?php
// src/Controller/AccountsController.php

namespace App\Controller;

use App\Controller\AppController;

class AccountsController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $accounts = $this->Paginator->paginate($this->Accounts->find());
        $this->set(compact('accounts'));
    }

    public function view($bank_number = null)
    {
        $this->loadModel('Transactions');
        $transactions = $this->Transactions->find('all');
        $this->set('transactions', $transactions);
    }

    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());

            $account->user_id = 1;

            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your new account has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add account.'));
        }
        $this->set('account', $account);
    }

    public function edit($bank_number)
    {
        $account = $this->Accounts->findByBank_number($bank_number)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your account has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your account.'));
        }
        $this->set('account', $account);
    }
}
