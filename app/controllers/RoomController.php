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

    public function indexAction(AppRequest $appRequest)
    {   
        // $request = new AppRequest;
        // // print_r($request);
        // AppRequest::validate($request);
        var_dump($appRequest);
        exit;
        // var_dump(Validation::validate());
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['rooms'] = Room::getAll();
        $this->data['content'] = 'room/index';
    }

    public function newAction()
    {   
        AppRequest::validate();
        exit;
        $this->data['content'] = 'room/new';
    }

    public function create(Request $request)
    {
        $post = $request->getPost();

        $name = $post->get('name');
        $description = $post->get('description');

        // $request = new AppRequest;
        // print_r($request);
        // var_dump();

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
        try {
            $post = $request->getPost();
            $id = $post->get('id');
            $name = $post->get('name');
            $description = $post->get('description');

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
