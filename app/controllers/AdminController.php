<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Room;
use Core\Http\Session;
use Core\Http\Request;

class AdminController extends Controller
{
    public $data = [];
    public $session;

    public function __construct()
    {
       $this->session = Session::getInstance();
    }
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction(Request $request)
    {   
        // $currentUser = $request->getSession('currentUser');
        // print_r($currentUser);
        // die;
        // if (!$currentUser) {
        //     header('Location: /default/index');
        //     exit;
        // }
        //
        $this->data['allUsers'] = User::getAll();

        $users = new User();
        $this->data['admins'] = $users->table('user')->where('role_id', '=', 1)->get();
        $this->data['users'] = $users->table('user')->where('role_id', '=', 2)->get();

        $rooms = new Room();
        $this->data['rooms'] = $rooms->table('room')->all();

        $this->data['mainContainer'] = 'default/dashboard.php';
        View::render('admin-layout/master.php', $this->data);
    }

}