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
use Core\Http\ResponseTrait;

class UserController extends Controller
{   
    use ResponseTrait;
    public array $data;

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAllRelation();

        $this->data['allRooms'] =  Room::all();
        $this->data['allRoles'] =  Role::all();
        $this->data['allPositions'] =  Position::all();

        $this->data['content'] = 'user/index';
    }

    public function newAction()
    {   
        $this->data['allRole'] = Role::all();
        $this->data['allRoom'] = Room::all();

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
        }
        if ($email != '') {
            $query = User::getBy('email', '=', $email);
            $numRows = count($query);
            if ($numRows == 1) {
                header('Location: /user/new');
                exit;
            } else {
                try {
                    User::create(['name' => $name, 
                               'email' => $email, 
                               'password' => $password, 
                               'role_id' => $role_id, 
                               'room_id' => $room_id]);
                    return $this->successResponse();
                } catch (\Throwable $th) {
                    return $this->errorResponse($th->getMessage());
                };

                header('Location: /admin/index');
                exit;
            }
        }
    }

    public function edit(Request $request)
    {      
        $id = $request->getGet()->all();
        var_dump($request);
        die;
        $this->data['allRoles'] = Role::all();
        $this->data['allRooms'] = Room::all();
        $this->data['allPositions'] = Position::all();
        
        $this->data['user'] = User::getById($id, 'id, name, email, role_id, room_id, position_id');

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
            try {
                User::update(['name' => $name,
                              'password' => $password,
                              'email' => $email,
                              'role_id' => $role_id,
                              'room_id' => $room_id,
                              'position_id' => $position_id]
                              , "id = $id");
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
                           
            header('Location: /user/index');
            exit;
        }
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        User::destroy("id = $id");

        header('Location: /user/index');
        exit;
    }
}