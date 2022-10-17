<?php

namespace App\Controllers;

use App\Models\Position;
use Core\Controller;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;


class UserController extends Controller
{
    use ResponseTrait;

    public array $data;

    public function indexAction()
    {
        $this->data['allUsers'] = User::getAllRelation();

        $this->data['allRooms'] =  Room::getAll();
        $this->data['allRoles'] =  Role::getAll();
        $this->data['allPositions'] =  Position::getAll();

        $this->data['content'] = 'user/index';
    }

    public function newAction()
    {
        $this->data['allRoles'] = Role::getAll();
        $this->data['allRooms'] = Room::getAll();
        $this->data['allPositions'] = Position::getAll();

        $this->data['content'] = 'user/new';
    }

    public function create(Request $request)
    {
        $post = $request->getPost();

        $name = $post->get('name');
        $password = $post->get('password');
        $email = $post->get('email');
        $role_id = $post->get('role');
        $room_id = $post->get('room');
        $position_id = $post->get('position');

        $query = User::getBy('email', '=', $email);
        $numRows = count($query);
        if ($numRows == 1) {
            return $this->errorResponse('User has been exist');
        } else {
            try {
                User::create(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                        'role_id' => $role_id,
                        'room_id' => $room_id,
                        'position_id' => $position_id
                    ]);
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        $this->data['allRoles'] = Role::getAll();
        $this->data['allRooms'] = Room::getAll();
        $this->data['allPositions'] = Position::getAll();
        $this->data['user'] = User::getById($id, 'id, name, email, role_id, room_id, position_id');

        $this->data['content'] = 'user/edit';
    }

    public function update(Request $request)
    {   
        $post = $request->getPost();

        $id = $post->get('id');
        $email = $post->get('email');

        $userCheck = User::getBy('email', '=', $email);
        $numRows = count($userCheck);

        if ($numRows == 1 && $userCheck[0]['id'] != $id) {
            return $this->errorResponse(showError('email existed'));
        } else {
            try {
                $name = $post->get('name');
                $password = $post->get('password');
                $role_id = $post->get('role');
                $room_id = $post->get('room');
                $position_id = $post->get('position');
    
                User::updateOne(
                    [
                        'name' => $name,
                        'password' => $password,
                        'email' => $email,
                        'role_id' => $role_id,
                        'room_id' => $room_id,
                        'position_id' => $position_id
                    ],
                    "id = $id");
                    
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        User::destroyOne("id = $id");

        header('Location: /user/index');
        exit;
    }

    public function filterAction(Request $request)
    {
        $get = $request->getGet();

        $role = $get->get('role_id');
        $room = $get->get('room_id');
        $position = $get->get('position_id');

        $users = User::filter($role, $room, $position);
        var_dump($get);
        die;
    }
}
