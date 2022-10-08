<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class HomeController extends Controller
{
    use ResponseTrait;

    public $data = [];
    public $session;

    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
       $this->session = Session::getInstance();
    }
 
    public function homepage()
    {
        $this->data['content'] = 'home/homepage';
        View::render('front-layouts/master.php',$this->data);

    }
    
    public function loginAction(Request $request)
    {
        $email = htmlspecialchars(addslashes($request->getPost()['email']));
        $password = addslashes($request->getPost()['password']);

        $user = new User();
        $currentUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->get();
        $number_rows = count($currentUser);

        if ($number_rows == 1) {
            $data = [
                'name' => $currentUser[0]['name'],
                'email' => $currentUser[0]['email'],
                'role_id' => $currentUser[0]['role_id'],
                'room_id' => $currentUser[0]['room_id'],
            ];
            $this->session->__unset('error');
            $this->session->__set('currentUser', $data);

            echo $this->successResponse();
        } else {

            echo $this->errorResponse($message = 'failed');
        }
    }

    public function logoutAction()
    {   
        $this->session->__unset('currentUser');

        setcookie('remember',null,-1);

        header('location: /home/homepage');
        exit;
    }

}
