<?php

namespace App\Controllers;

use App\Requests\AppRequest;
use App\models\User;
use App\models\Position;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class PositionController extends AppController
{
    use ResponseTrait;

    public $title = 'Vị trí';

    public object $model;
    
    public array $data;

    public function __construct()
    {
        $this->model = new Position;
    }

    public function indexAction()
    {
        $results = User::getAllRelation();
        $this->data['allUsers'] = $results['results'];
        
        $this->data['positions'] = $this->model->getAll();
        $this->data['content'] = 'position/index';
    }

    public function newAction()
    {
        $this->data['content'] = 'position/new';
    }

    public function create(Request $request)
    {
        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate(Position::rules(), $request, 'post');

        if (in_array('error', $resultVali)) {
            return $this->errorResponse(showError($resultVali[array_key_last($resultVali)]) . " (" . array_key_last($resultVali) . ")");
        } 

        $name = $resultVali['name'];
        $description = $resultVali['description'];

        $query = $this->model->getBy('name', '=', $name);
        $numRows = count($query);

        if ($numRows == 1) {
            return $this->errorResponse('Position has been exist');
        } else {
            try {
                $this->model->create(
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

        $this->data['position'] = $this->model->getById($id, 'id, name, description');
        $this->data['content'] = 'position/edit';
    }

    public function update(Request $request)
    {   
        $post = $request->getPost()->all();
        
        $checkPosition = $this->model->getById($post['id']);
        $changeData = false;
        foreach ($post as $key => $value) {
            if ($checkPosition[$key] != $value) {
                $changeData = true;
                break;
            }
        }

        if (!$changeData) {
            return $this->errorResponse('Nothing to update');
        }

        $appRequest = new AppRequest;
        $resultVali = $appRequest->validate(Position::rules('add', ['id' => ['required', 'filled']]), $request, 'post');

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
                "id = $id");

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function delete(Request $request)
    {
        $id = $request->getGet()->get('id');

        $this->model->destroyOne("id = $id");

        header('Location: /position/index');
        exit;
    }

    public function changePosition(Request $request)
    {
        try {
        $post = $request->getPost()->all();
        $post = $post['data'];

        $user = new User;
        $arrayId = array();
        foreach ($post as $key => $value) {
            $position = $this->model->getBy('name', '=', $value);
            $arrayId[$key] = (int)$position[0]['id'];
        }
            $user->updateMultiByName($arrayId, 'position_id');
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
