<?php

namespace App\Controllers;

use App\Requests\AppRequest;
use App\models\User;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\Validation;

class RoomController extends AppController
{
    use ResponseTrait;

    public $title = 'Phòng';

    public object $model;
    
    public array $data;

    public function __construct()
    {
        $this->model = new Room;
    }

    public function indexAction()
    {   
        $results = User::getAllRelation();
        $this->data['allUsers'] = $results['results'];

        $this->data['rooms'] = $this->model->getAll();
        $this->data['content'] = 'room/index';
    }



    public function newAction()
    {   
        
        $this->data['content'] = 'room/new';
    }

    public function create(Request $request)
    {   
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate(Room::rules(), $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        $name = $resultVali['name'];
        $description = $resultVali['description'];

        $query = $this->model->getBy('name', '=', $name);
        $numRows = count($query);

        if ($numRows == 1) {
            return $this->errorResponse('Room has been exist');
        } else {
            try {
                $this->model->create(
                    [
                        'name' => $name,
                        'description' => $description
                    ]
                );
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        $this->data['room'] = $this->model->getById($id, 'id, name, description');
        $this->data['content'] = 'room/edit';
    }

    public function update(Request $request)
    {   
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate(Room::rules('add', ['id' => ['required', 'filled']]), $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        try {
            $id = $resultVali['id'];
            $name = $resultVali['name'];
            $description = $resultVali['description'];

            $this->model->updateOne(
                [
                    'name' => $name,
                    'description' => $description
                ],
                "id = $id"
            );

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function delete(Request $request)
    {
        $id = $request->getGet()->get('id');

        $this->model->destroyOne("id = $id");

        header('Location: /room/index');
        exit;
    }

    public function changeRoom(Request $request)
    {
        try {
        $post = $request->getPost()->all();
        $post = $post['data'];

        $user = new User;
        $arrayId = array();
        foreach ($post as $key => $value) {
            $room = $this->model->getBy('name', '=', $value);
            $arrayId[$key] = (int)$room[0]['id'];
        }
            $user->updateMultiByName($arrayId, 'room_id');
            return $this->successResponse();
        } catch (\Throwable $th) {
            
            return $this->errorResponse($th->getMessage());
        }
    }
}
