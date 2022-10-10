<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;


class AuthController extends Controller 
{   
    public $session;
    public $currentUser = [];

    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
       $this->session =  Session::getInstance();
    }
    
    public function index()
    {   

        $currentUser = $this->session->__isset('currentUser');
        if ($currentUser) {
            header('Location: admin/index');
        } else {

            header('Location: default/index');
            exit;
        }
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


        if ($inputUser['role_id'] != 1) {
            header('Location: /default/index');
        } else {
            $this->currentUser = $inputUser;
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

    public function logoutAction(Request $request)
    {   
        $request->deleteUser();
        header('Location: /default/index');
    }
    
}