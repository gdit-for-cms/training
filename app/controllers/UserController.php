<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Session;
use Core\Http\Request;

class UserController extends Controller
{
    public $data = [];
    
    public function __construct()
    {
       $this->session =  Session::getInstance();
    }

    public function newAction()
    {   
        $role = new Role();
        $this->data['allRole'] = $role->table('role')->all();

        $room = new Room();
        $this->data['allRoom'] = $room->table('room')->all();

        $this->data['mainContainer'] = 'user/new.php';
        View::render('admin-layout/master.php', $this->data);
        
    }

    public function createAction(Request $request)
    {
        
        $post = $request->getPost();

        $name = htmlspecialchars(addslashes($post['name']));
        $password = htmlspecialchars(addslashes($post['password']));
        $email = htmlspecialchars(addslashes($post['email']));
        $role_id = htmlspecialchars(addslashes($post['role']));
        $room_id = htmlspecialchars(addslashes($post['room']));

        if ($name == '' || $role_id == '' || $email == '') {
            $this->session->__set('errorCreateUser', 'Create room failed');
            header('Location: /user/new');
            exit;
        }
        if($email != '') {
            $user = new User();
            $query = $user->table('user')->where('email', '=', $email)->get();
            $num_rows = count($query);
            if($num_rows >= 1){
                header('Location: /user/new');
                exit;
            }else{
                $this->session->__unset('errorCreateUser');
                $password = base64_encode($password);
                $user->insert(['name' => $name, 
                               'email' => $email, 
                               'password' => $password, 
                               'role_id' => $role_id, 
                               'room_id' => $room_id]);

                header('Location: /admin/index');
                exit;
            }
        }
 
    }


    public function editAction(Request $request)
    {   
        $id = $request->getGet()['id'];

        $role = new Role();
        $this->data['allRole'] = $role->table('role')->all();

        $room = new Room();
        $this->data['allRoom'] = $room->table('room')->all();

        $user = new User();
        $this->data['user'] = $user->table('user')->find($id, 'id, name, email, role_id, room_id');

        $this->data['mainContainer'] = 'user/edit.php';
        View::render('admin-layout/master.php', $this->data);
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = htmlspecialchars(addslashes($get['id']));
        $name = htmlspecialchars(addslashes($get['name']));
        $password = base64_encode(htmlspecialchars(addslashes($get['password'])));
        $email = htmlspecialchars(addslashes($get['email']));
        $role_id = htmlspecialchars(addslashes($get['role']));
        $room_id = htmlspecialchars(addslashes($get['room']));

        if ($email != '') {
            $user = new User();
            $user->update(['name' => $name,
                           'password' => $password,
                           'email' => $email,
                           'role_id' => $role_id,
                           'room_id' => $room_id]
                           , "id = $id");
                           
            header('Location: /admin/index');
            exit;
        }
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()['id'];

        $user = new User();
        $user->destroy("id = $id");

        header('Location: /admin/index');
        exit;
    }
}