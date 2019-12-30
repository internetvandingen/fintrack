<?php
namespace App\Controller;

use App\Controller\AppController;

class LedgersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function all()
    {
        $ledgers = $this->paginate($this->Ledgers);
        $this->set(compact('ledgers'));
        $this->set('_serialize', ['ledgers']);
    }

    public function index()
    {
        $logged_id = $this->Auth->user('id');
        $ledgers = $this->Ledgers->findByUser_id($logged_id);
        $ledgers = $this->paginate($ledgers);
        $this->set(compact('ledgers'));
        $this->set('_serialize', ['ledgers']);
    }

    public function add()
    {
        $ledger = $this->Ledgers->newEntity();
        if ($this->request->is('post')) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->getData());
            $ledger->user_id = $this->Auth->user('id');
            $ledger->balance = 0;

            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The new ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The new ledger could not be saved. Please, try again.'));
        }
        $this->set(compact('ledger'));
        $this->set('_serialize', ['ledger']);
    }


    public function edit($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ledger = $this->Ledgers->patchEntity(
                                 $ledger, $this->request->getData(), 
                                 ['accessibleFields' => ['id'=>false, 'user_id'=>false, 'balance'=>false]]
                                 );
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
        }
        $this->set(compact('ledger'));
        $this->set('_serialize', ['ledger']);
        $this->set('id', $id);
    }

    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['Users']
        ]);
        $this->set(compact('ledger'));
        $this->set('_serialize', ['ledger']);
        $this->set('id', $id);
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        // ledger id 0 must be kept to store unassigned transactions
        if ($id != 0 && $this->Ledgers->delete($ledger)) {
            $this->Flash->success(__('The ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
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
        } else if (in_array($action, ['edit', 'delete'])){
            // require id
            $id = $this->request->getParam('pass.0');
            if (!$id) {
                return false;
            }
            $logged_id = $this->Auth->user('id');
            if ($logged_id === $this->Ledgers->get($id)->user_id){
                return true;
            }
        }

        return false;
    }

}


