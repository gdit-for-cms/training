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
    
    protected function before()
    {
        if (!checkUser()) {
            header('Location: /default/index');
            exit;
        }
    }

    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data);
    }

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAll();
        $users = new User();
        $this->data['admins'] = $users->table('user')->where('role_id', '=', 1)->get();
        $this->data['users'] = $users->table('user')->where('role_id', '=', 2)->get();

        $rooms = new Room();
        $this->data['rooms'] = $rooms->table('room')->all();

        $this->data['content'] = 'user/index';
    }

    public function newAction()
    {   
        $role = new Role();
        $this->data['allRole'] = $role->table('role')->all();

        $this->data['allRoom'] = Room::All();

        $this->data['content'] = 'user/new';
        
    }

    public function createAction(Request $request)
    {
        
        $post = $request->getPost();
        $name = $post['name'];
        $password = $post['password'];
        $email = $post['email'];
        $role_id = $post['role'];
        $room_id = $post['room'];

        if ($name == '' || $role_id == '' || $email == '') {
            $this->data['error'] = showError('create');
            $this->data['content'] = 'user/new';
            view::render('admin/back-layouts/master.php', $this->data);
            // exit;
        }
        if ($email != '') {
            $user = new User();
            $query = $user->table('user')->where('email', '=', $email)->get();
            $num_rows = count($query);
            if($num_rows >= 1){
                header('Location: /user/new');
                exit;
            }else{
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

        $this->data['allRole'] = Role::All();
        
        $this->data['allRoom'] = Room::All();
        
        $user = new User();
        $this->data['user'] = $user->table('user')->find($id, 'id, name, email, role_id, room_id');

        $this->data['content'] = 'user/edit';
        View::render('admin/back-layouts/master.php', $this->data);
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = $get['id'];
        $name = $get['name'];
        $password = $get['password'];
        $email = $get['email'];
        $role_id = $get['role'];
        $room_id = $get['room'];

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