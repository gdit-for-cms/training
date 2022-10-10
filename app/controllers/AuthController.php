<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;


class AuthController extends Controller 
{   
    protected function before() {
        if (!checkUser()) {
            header('Location: /default/index');
            exit;
        }
    }

    public function index()
    {   
        View::render('default/index.php');
    }

    public function loginAction(Request $request)
    {   
        $post = $request->getPost();
        
        $email = htmlspecialchars(addslashes($post['email']));
        $password = htmlspecialchars(addslashes($post['password']));
        
        $user = new User();
        $inputUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->first();
        
        if (!$inputUser) {
            header('Location: /default/index');
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
            $this->data['errorLogin'] = 'Email or password is incorrect';
            View::render('default/index.php', $this->data);
        }
    }

    public function logout(Request $request)
    {   
        $request->deleteUser();
        header('Location: /default/index');
    }
    
}