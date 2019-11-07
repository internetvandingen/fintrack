<?php
// src/Controller/AccountsController.php

namespace App\Controller;

use App\Controller\AppController;

class AccountsController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('Paginator');
    }

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
        $transactions = $this->paginate($this->Transactions);
        $this->set(compact('transactions'));
        $this->set('_serialize', ['transactions']);
    }

    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());

            $account->user_id = $this->Auth->user('id');

            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your new account has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add account.'));
        }
        $this->set('account', $account);
    }

    public function edit($id)
    {
        $account = $this->Accounts->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Accounts->patchEntity($account, $this->request->getData(), ['accessibleFields' => ['user_id' => false]]);
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your account has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your account.'));
        }
        $this->set('account', $account);
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
    
        // Check that the account belongs to the current user.
        $account = $this->Accounts->findById($id)->first();
    
        return $account->user_id === $user['id'];
    }
}
