<?php

namespace App\Controllers;

use App\Requests\AppRequest;
use App\Models\Position;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use Core\View;

class UserController extends AppController
{
    use ResponseTrait;

    public $title = 'Người dùng';

    public object $model;
    
    public array $data;

    public function __construct()
    {
        $this->model = new User;
    }

    public function indexAction(Request $request)
    {   
        $resultsPerPage = 3;
        
        $get = $request->getGet()->all();
        if (!isset($get['page'])) {
            $get['page'] = '1';
        }
        array_shift($get);
        $results = $this->model->getAllRelation($get, $resultsPerPage);
        $this->data['allUsers'] = $results['results'];
        $numbersOfResult = $results['numbersOfPage'];

        $numbersOfPage = ceil($numbersOfResult/$resultsPerPage);
        $this->data['numbersOfPage'] = $numbersOfPage;

        $this->data['allRoles'] = Role::getAll();
        $this->data['allRooms'] = Room::getAll();
        $this->data['allPositions'] = Position::getAll();

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
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate($this->model->rules(), $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        $name = $resultVali['name'];
        $password = $resultVali['password'];
        $email = $resultVali['email'];
        $role_id = $resultVali['role_id'];
        $room_id = $resultVali['room_id'];
        $position_id = $resultVali['position_id'];

        $query = $this->model->getBy('email', '=', $email);
        $numRows = count($query);
        if ($numRows == 1) {
            return $this->errorResponse('User has been exist');
        } else {
            try {
                $this->model->create(
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
        $this->data['user'] = $this->model->getById($id, 'id, name, email, role_id, room_id, position_id');

        $this->data['content'] = 'user/edit';
    }

    public function update(Request $request)
    {   
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate($this->model->rules('remove', ['password']), $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        $id = $resultVali['id'];
        $email =$resultVali['email'];

        $userCheck = $this->model->getBy('email', '=', $email);
        $numRows = count($userCheck);

        if ($numRows == 1 && $userCheck[0]['id'] != $id) {
            return $this->errorResponse(showError('email existed'));
        } else {
            try {
                $name = $resultVali['name'];
                $password = $resultVali['password'];
                $role_id = $resultVali['role_id'];
                $room_id = $resultVali['room_id'];
                $position_id = $resultVali['position_id'];
    
                $this->model->updateOne(
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

        $this->model->destroyOne("id = $id");

        header('Location: /user/index');
        exit;
    }
}
