<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash'); // For flash messages
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'username', 'password' => 'password']
                ]
            ],
            'loginAction' => ['controller' => 'Users', 'action' => 'login'],
            'loginRedirect' => ['controller' => 'Users', 'action' => 'dashboard'],
            'logoutRedirect' => ['controller' => 'Users', 'action' => 'login']
        ]);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow login without being authenticated
        $this->Auth->allow(['login']);
    }

   public function login()
{
    $user = $this->request->getSession()->read('Auth.User');
    if ($user) {
        // Already logged in → go to dashboard index
        return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

    if ($this->request->is('post')) {
        $username = $this->request->getData('username');
        $password = $this->request->getData('password');

        if ($username === 'admin' && $password === 'password') {
            $this->request->getSession()->write('Auth.User', ['username' => 'admin']);
            // Redirect to Dashboard controller, index action
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        } else {
            $this->Flash->error(__('Invalid username or password'));
        }
    }
}



    public function dashboard()
    {
        $user = $this->request->getSession()->read('Auth.User');
        if (!$user) {
            return $this->redirect(['action' => 'login']);
        }
        $this->set('user', $user);
    }
    public function home()
    {
        $user = $this->request->getSession()->read('Auth.User');

        if ($user) {
            // Already logged in → send to dashboard
            return $this->redirect(['action' => 'dashboard']);
        } else {
            // Not logged in → show login page
            return $this->redirect(['action' => 'login']);
        }
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        return $this->redirect(['action' => 'login']);
    }
}
