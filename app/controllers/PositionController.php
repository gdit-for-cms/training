<?php

namespace App\Controllers;

use App\models\User;
use App\models\Position;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class PositionController extends AppController
{
    use ResponseTrait;

    public array $data;

    public function indexAction()
    {
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['positions'] = Position::getAll();
        $this->data['content'] = 'position/index';
    }

    public function newAction()
    {
        $this->data['content'] = 'position/new';
    }

    public function create(Request $request)
    {
        $post = $request->getPost();

        $name = $post->get('name');
        $description = $post->get('description');

        $query = Position::getBy('name', '=', $name);
        $numRows = count($query);

        if ($numRows == 1) {
            return $this->errorResponse('Position has been exist');
        } else {
            try {
                Position::create(
                    [
                        'name' => $name,
                        'description' => $description
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

        $this->data['position'] = Position::getById($id, 'id, name, description');
        $this->data['content'] = 'position/edit';
    }

    public function update(Request $request)
    {
        try {
            $post = $request->getPost();

            $id = $post->get('id');
            $name = $post->get('name');
            $description = $post->get('description');

            Position::updateOne(
                [
                    'name' => $name,
                    'description' => $description
                ],
                "id = $id");

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function delete(Request $request)
    {
        $id = $request->getGet()->get('id');

        Position::destroyOne("id = $id");

        header('Location: /position/index');
        exit;
    }
}
