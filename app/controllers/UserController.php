<?php

namespace App\Controllers;

use App\Models\Position;
use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;

class UserController extends Controller
{
    public array $data;

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAll();
        $users = new User();
        $this->data['admins'] =  $users->table('user')->where('role_id', '=', 1)->get();
        $this->data['users'] =  $users->table('user')->where('role_id', '=', 2)->get();

        $this->data['rooms'] =  $users->table('room')->all();

        $this->data['roles'] =  $users->table('role')->all();

        $this->data['positions'] =  $users->table('position')->all();

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
            $numRows = count($query);
            if ($numRows == 1) {
                header('Location: /user/new');
                exit;
            } else {
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
        $this->data['allPosition'] = Position::All();
        
        $user = new User();
        $this->data['user'] = $user->table('user')->find($id, 'id, name, email, role_id, room_id, position_id');

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
        $position_id = $get['position'];

        if ($email != '') {
            $user = new User();
            $user->update(['name' => $name,
                           'password' => $password,
                           'email' => $email,
                           'role_id' => $role_id,
                           'room_id' => $room_id,
                           'position_id' => $position_id]
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

        header('Location: /user/index');
        exit;
    }
}