<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // pages accessible without authentication (login)
        $this->Auth->allow(['login', 'logout', 'add']);
        $this->loadModel('Accounts');
        $this->set('links', []);
    }

    public function all()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        $this->set('links', [
                             ['Users', 'add', 'New user'],
                            ]);
    }

    public function index()
    {
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id);
        $user->accounts = $this->Accounts->find()->where(['user_id' => $id]);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->set('links', [
                             ['Users', 'index', 'View user', $id],
                             ['Users', 'edit', 'Edit user', $id],
                             ['Users', 'delete', 'Delete user', $id],
                             ['Accounts', 'index', 'List accounts'],
                             ['Accounts', 'add', 'Add accounts']
                             ]);
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $user->accounts = $this->Accounts->find()->where(['user_id' => $id]);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->set('links', [
                             ['Users', 'index', 'View user', $id],
                             ['Users', 'edit', 'Edit user', $id],
                             ['Users', 'delete', 'Delete user', $id],
                             ['Accounts', 'index', 'List accounts'],
                             ['Accounts', 'add', 'Add accounts']
                             ]);
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $query = $articles->query();
                $query->insert(['user_id', 'name', 'description', 'balance'])
                    ->values([
                        'user_id' => $user->id,
                        'name' => 'Temporary',
                        'description' => 'To be assigned',
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
        $this->set('links', []);
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
        $this->set('links', [
                             ['Users', 'index', 'View user', $id],
                             ['Users', 'edit', 'Edit user', $id],
                             ['Users', 'delete', 'Delete user', $id],
                             ['Accounts', 'index', 'List accounts'],
                             ['Accounts', 'add', 'Add accounts']
                             ]);
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
        if ($user['id'] === 1){
             return true;
        }

        $action = $this->request->getParam('action');
        if ($action === 'index') {
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

