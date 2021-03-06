<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // pages accessible without authentication ( or login)
        $this->Auth->allow(['login', 'logout', 'add']);
        $this->loadModel('Accounts');
    }

    public function all()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    public function index()
    {
        return $this->redirect(['controller'=>'Users', 'action' => 'view', $this->Auth->user('id')]);
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $user->accounts = $this->Accounts->find()->where(['user_id' => $id]);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->set('id', $id);
    }

    public function add()
    {
        $this->loadModel('Ledgers');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                // insert temporary ledger
                $query = $this->Ledgers->query();
                $query->insert(['user_id', 'name', 'description', 'balance'])
                    ->values([
                        'user_id' => $user->id,
                        'name' => 'Temporary',
                        'description' => 'To be assigned',
                        'balance' => 0,
                    ])
                    ->execute();

                // get id of temporary ledger
                $temp_ledger_id = $this->Ledgers->find()->where(['user_id'=>$user->id, 'name'=>'Temporary'])->first()->id;

                // store it in user
                $query = $this->Users->query();
                $query->update()->set(['temp_ledger_id' => $temp_ledger_id])->where(['id' => $user->id])->execute();

                // insert internal transfers ledger
                $query = $this->Ledgers->query();
                $query->insert(['user_id', 'name', 'description', 'balance'])
                    ->values([
                        'user_id' => $user->id,
                        'name' => 'Internal transfers',
                        'description' => 'Transfers between owned accounts, sum should always be zero',
                        'balance' => 0,
                    ])
                    ->execute();
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }


    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->set('id', $id);
    }


    public function delete($id = null)
    {
        $this->loadModel('Transactions');
        $this->loadModel('Ledgers');
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        // delete transactions
        $accounts = $this->Accounts->find()->where(['user_id' => $id])->extract('id')->toList();
        if(!empty($accounts)){
            $this->Transactions->deleteAll(['account_id IN'=>$accounts]);
        }

        // delete ledgers
        $this->Ledgers->deleteAll(['user_id'=>$id]);
        // delete accounts
        $this->Accounts->deleteAll(['user_id'=>$id]);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'logout']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your email or password is incorrect.');
        }
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if ($action === 'index' || $action === 'add') {
            return true;
        } else if (in_array($action, ['edit', 'view', 'delete'])) {
            // view, edit and delete require id
            $id = $this->request->getParam('pass.0');
            if (!$id) {
                return false;
            }
            // Check that the account belongs to the current user.
            $logged_id = $this->Auth->user('id');
            if ($id == $logged_id) {
                return true;
            }
        }

        return false;
    }
}

