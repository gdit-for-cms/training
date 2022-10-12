<?php

namespace App\Controllers;

use App\Models\Position;
use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;
use Core\Http\Response;

class UserController extends Controller
{
    public array $data;

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAllRelation();

        $this->data['allRooms'] =  Room::allRoom();
        $this->data['allRoles'] =  Role::allRole();
        $this->data['allPositions'] =  Position::allPosition();

        $this->data['content'] = 'user/index';
    }

    public function newAction()
    {   
        $this->data['allRole'] = Role::allRole();
        $this->data['allRoom'] = Room::allRoom();

        $this->data['content'] = 'user/new';
    }

    public function createAction(Request $request)
    {   
        $post = $request->getPost();

        $name = $post->get('name');
        $password = $post->get('password');
        $email = $post->get('email');
        $role_id = $post->get('role');
        $room_id = $post->get('room');

        if ($name == '' || $role_id == '' || $email == '') {
            $this->data['error'] = showError('create');
            $this->data['content'] = 'user/new';
            view::render('admin/back-layouts/master.php', $this->data);
            // exit;
        }
        if ($email != '') {
            $query = User::getDataBy('email', '=', $email);
            $numRows = count($query);
            if ($numRows == 1) {
                header('Location: /user/new');
                exit;
            } else {
                User::insertData(['name' => $name, 
                               'email' => $email, 
                               'password' => $password, 
                               'role_id' => $role_id, 
                               'room_id' => $room_id]);

                header('Location: /admin/index');
                exit;
            }
        }
    }

    public function edit(Request $request)
    {      
        $id = $request->getGet()->get('id');
        
        $this->data['allRoles'] = Role::allRole();
        $this->data['allRooms'] = Room::allRoom();
        $this->data['allPositions'] = Position::allPosition();
        
        $this->data['user'] = User::getDataById($id, 'id, name, email, role_id, room_id, position_id');

        $this->data['content'] = 'user/edit';
    }

    public function updateAction(Request $request)
    {   
        $get = $request->getGet();

        $id = $get->get('id');
        $name = $get->get('name');
        $password = $get->get('password');
        $email = $get->get('email');
        $role_id = $get->get('role');
        $room_id = $get->get('room');
        $position_id = $get->get('position');

        if ($email != '') {
            User::updateData(['name' => $name,
                              'password' => $password,
                              'email' => $email,
                              'role_id' => $role_id,
                              'room_id' => $room_id,
                              'position_id' => $position_id]
                              , "id = $id");
                           
            header('Location: /user/index');
            exit;
        }
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        User::destroyData("id = $id");

        header('Location: /user/index');
        exit;
    }
}