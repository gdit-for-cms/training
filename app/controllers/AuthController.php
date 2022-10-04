<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;


class AuthController extends Controller
{   
    private $_table = 'user';
    public $session  ;
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
            View::render('admin/index.php');
            exit;
        } else {

            header('Location:../default/index');

            exit;
        }
    }

    public function loginAction()
    {   
        
        $request = new Request;
        $post = $request->getPost();

        $email = $post['email'];
        $password = $post['password'];

        // $userModel = new User();
        // $userModel->login($email, $password);
        $user = new User();
        $currentUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->get();
        // var_dump($user);
        // echo '123';
        $number_rows = count($currentUser);
        // echo($user[0]['id']);
        if ($number_rows == 1) {
            $data = [
                'name' => $currentUser[0]['name'],
                'email' => $currentUser[0]['email'],
                'role_id' => $currentUser[0]['role_id'],
                'room_id' => $currentUser[0]['room_id'],
            ];
            $session = Session::getInstance();
            $session->__unset('error');
            $session->__set('currentUser', $data);
            // print_r($_SESSION['id']);

            $token = uniqid('', true) . time();
            $user->table('user')->where('id', '=', 1)->update(['token' => $token]);

            setcookie('remember', $token, time() + 86400*30, '/');
            header("location: /admin/index");
        } else {
            $session = Session::getInstance();
            $session->__set('error', 'email or password is incorrect');
            header('Location: /');
        }
    }

    public function logoutAction()
    {   
        $session = Session::getInstance();
        $session->__unset('currentUser');

        setcookie('remember',null,-1);

        header('location: /');
        exit;
    }
    
    public function deleteAction()
    {
        $user = new User();
        $data = $user->destroy('id = 1');

    }
    public function testAction()
    {
        View::render('default/test.php');
    }
}