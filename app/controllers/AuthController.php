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
        $password = base64_encode($password);

        $user = new User();
        $inputUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->get();

        $this->currentUser = $inputUser;
        $number_rows = count($this->currentUser);
        if ($number_rows == 1 && $this->currentUser[0]['role_id'] == 1) {
            $data = [
                'name' => $this->currentUser[0]['name'],
                'email' => $this->currentUser[0]['email'],
                'role_id' => $this->currentUser[0]['role_id'],
                'room_id' => $this->currentUser[0]['room_id'],
            ];
            // $this->session->__unset('errorLogin');
            $test = $request->saveUser($data);
            print_r($test);
            $test1 = $request->getUser();
            print_r($test1);
            die;
            $this->session->__set('currentUser', $data);
            
            if (isset($post['rememberPasswordCheck'])) {
                $token = uniqid('', true) . time();
                $user->table('user')->where('id', '=', $this->currentUser[0]['id'])->update(['token' => $token]);
    
                setcookie('remember', $token, time() + 86400*30, '/');
                // header("location: /admin/index");
                exit;
            } else {
                header("location: /admin/index");
                exit;
            }

        } else {
            $this->session->__set('errorLogin', 'email or password is incorrect');
            header('Location: /');
            exit;
        }
    }

    public function logoutAction(Request $request)
    {   
        $request->deleteUser();
        $test1 = $request->getUser();
        var_dump($test1);
        $this->session->__unset('errorLogin');

        setcookie('remember',null,-1);

        // header('location: /');
        // exit;
    }
    
    public function deleteAction()
    {
        $user = new User();
        $user->destroy('id = 1');

    }
    public function testAction()
    {
        print_r($_SESSION);
    }
}