<?php

namespace App\Controller;

use App\Controller\AppController;

class AccountsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->set('links', []);
    }

    public function all()
    {
        $accounts = $this->Accounts;
        $accounts = $this->Paginator->paginate($accounts);
        $this->set(compact('accounts'));
        $this->set('_serialize', ['accounts']);
        $this->set('links', [['Accounts', 'index', 'View accounts'],
                             ['Accounts', 'add', 'Add accounts']]);
    }

    public function index()
    {
        $logged_id = $this->Auth->user('id');
        $accounts = $this->Accounts->find()->where(['user_id' => $logged_id]);
        $accounts = $this->Paginator->paginate($accounts);
        $this->set(compact('accounts'));
        $this->set('_serialize', ['accounts']);
        $this->set('links', [['Accounts', 'index', 'View accounts'],
                             ['Accounts', 'add', 'Add accounts']]);
    }

    public function view($id = null)
    {
        $this->loadModel('Transactions');
        $transactions = $this->Transactions->find()->where(['account_id' => $id]);
        $transactions = $this->paginate($transactions);
        $this->set(compact('transactions'));
        $this->set('_serialize', ['transactions']);
        $this->set('account', $this->Accounts->get($id));
        $this->set('links', [['Accounts', 'index', 'View accounts'],
                             ['Accounts', 'add', 'Add accounts'],
                             ['Accounts', 'edit', 'Edit account', $id],
                             ['Transactions', 'upload', 'Upload transactions'],
                             ['Transactions', 'add', 'New transaction']]);
    }

    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data["name"] = $data["name"] . " (" . $data["bank_name"] . ")";
            unset($data["bank_name"]);

            $account = $this->Accounts->patchEntity($account, $data);

            $account->user_id = $this->Auth->user('id');

            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your new account has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add account.'));
        }
        $account["name"] = preg_replace("/ \([^\(]+\)$/", "", $account["name"]);
        $this->set('account', $account);
        $this->set('links', [['Accounts', 'index', 'View accounts'],
                             ['Accounts', 'add', 'Add accounts']]);
    }

    public function edit($id)
    {
        $account = $this->Accounts->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data["name"] = $data["name"] . " (" . $data["bank_name"] . ")";
            unset($data["bank_name"]);

            $this->Accounts->patchEntity($account, $data, ['accessibleFields' => ['user_id' => false]]);
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Your account has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your account.'));
        }
        $account["name"] = preg_replace("/ \([^\(]+\)$/", "", $account["name"]);
        $this->set('account', $account);
        $this->set('links', [['Accounts', 'index', 'View accounts'],
                             ['Accounts', 'add', 'Add accounts'],
                             ['Accounts', 'view', 'View account', $id],
                             ['Transactions', 'upload', 'Upload transactions'],
                             ['Transactions', 'add', 'New transaction']]);
    }

    public function isAuthorized($user)
    {
        if ($user['id'] === 1){
             return true;
        }

        $action = $this->request->getParam('action');
        // The index and add action are always allowed to logged in users.
        if (in_array($action, ['index', 'add'])){
            return true;
        }
        elseif (in_array($action, ['view', 'edit'])) {
            // require an id.
            $id = $this->request->getParam('pass.0');
            if (!$id) {
                return false;
            }
            // Check that the account belongs to the current user.
            $logged_id = $this->Auth->user('id');
            if ($logged_id === $this->Accounts->get($id)->user_id){
                return true;
            }
        }

        return false;
    }
}
