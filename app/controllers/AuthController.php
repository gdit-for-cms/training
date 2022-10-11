<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;

class AuthController extends Controller 
{   
    public array $data;

    protected function before() {
        if (checkUser()) {
            header('Location: /admin/index');
            exit;
        }
        $this->data['title'] = 'Login';
    }

    public function loginAction()
    {  
        View::render('admin/auth/login.php');
    }

    public function loginProcessAction(Request $request)
    {
        $post = $request->getPost();

        $email = $post['email'];
        $password = $post['password'];

        $user = new User();
        $inputUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->first();

        if (!$inputUser) {
            $this->data['error'] = showError('login');

            View::render('default/index.php', $this->data);
            exit;
        }

        $this->currentUser = $inputUser;
        if ($this->currentUser['role_id'] == 1) {
            $data = [
                'name' => $this->currentUser['name'],
                'email' => $this->currentUser['email'],
                'role_id' => $this->currentUser['role_id'],
                'room_id' => $this->currentUser['room_id'],
            ];
            
            $request->saveUser($data);
            
            header('Location: /admin/index');

        } else {
            $this->data['error'] = showError('login');

            View::render('default/index.php', $this->data);
        }
    }

    public function logout(Request $request)
    {   
        $request->deleteUser();
        header('Location: /auth/login');
    }
    
}