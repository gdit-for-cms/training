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
    private $request ;
    public $data = [];
    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();   
    }

    public function newAction()
    {   
        $role = new Role();
        $this->data['allRole'] = $role->table('role')->all();

        $room = new Room();
        $this->data['allRoom'] = $room->table('room')->all();
        View::render('user/new.php', $this->data);
        
    }

    public function createAction()
    {
        
        $post = $this->request->getPost();

        $name = htmlspecialchars($post['name']);
        $password = htmlspecialchars($post['password']);
        $email = htmlspecialchars($post['email']);
        $role_id = htmlspecialchars($post['role']);
        $room_id = htmlspecialchars($post['room']);

        if($email != '') {
            $user = new User();
            $query = $user->table('user')->where('email', '=', $email)->get();
            $num_rows = count($query);
            if($num_rows >= 1){
                header('Location: /user/new');
                exit;
            }else{
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


    public function editAction()
    {   
        $id = $this->request->getGet()['id'];

        $role = new Role();
        $this->data['allRole'] = $role->table('role')->all();

        $room = new Room();
        $this->data['allRoom'] = $room->table('room')->all();

        $user = new User();
        $this->data['user'] = $user->table('user')->find($id, 'id, name, email, role_id, room_id');

        View::render('user/edit.php', $this->data);
    }

    public function updateAction()
    {
        $get = $this->request->getGet();

        $id = htmlspecialchars($get['id']);
        $name = htmlspecialchars($get['name']);
        $password = base64_encode(htmlspecialchars($get['password']));
        $email = htmlspecialchars($get['email']);
        $role_id = htmlspecialchars($get['role']);
        $room_id = htmlspecialchars($get['room']);

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

    public function deleteAction()
    {
        $id = $this->request->getGet()['id'];

        $user = new User();
        $user->destroy("id = $id");

        header('Location: /admin/index');
        exit;
    }
}