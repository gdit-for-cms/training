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

    public array $data;

    public function indexAction()
    {   
        // $request = new AppRequest;
        // // print_r($request);
        // AppRequest::validate($request);
        // var_dump($appRequest);
        // exit;
        // var_dump(Validation::validate());
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['rooms'] = Room::getAll();
        $this->data['content'] = 'room/index';
    }

    public function newAction()
    {   
        
        $this->data['content'] = 'room/new';
    }

    public function create(Request $request)
    {   
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate([
            'name' => [
                'required',
                'string',
                'filled',
            ],
            'description' => [
                'string',
            ],
        ], $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        $name = $resultVali['name'];
        $description = $resultVali['description'];

        $query = Room::getBy('name', '=', $name);
        $numRows = count($query);

        if ($numRows == 1) {
            return $this->errorResponse('Room has been exist');
        } else {
            try {
                Room::create(
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

        $this->data['room'] = Room::getById($id, 'id, name, description');
        $this->data['content'] = 'room/edit';
    }

    public function update(Request $request)
    {   
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate([
            'id' => [
                'required',
                'filled',
            ],
            'name' => [
                'required',
                'string',
                'filled',
            ],
            'description' => [
                'string',
            ],
        ], $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        try {
            $id = $resultVali['id'];
            $name = $resultVali['name'];
            $description = $resultVali['description'];

            Room::updateOne(
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

        Room::destroyOne("id = $id");

        header('Location: /room/index');
        exit;
    }
}
