<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Position;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class PositionController extends Controller
{   
    use ResponseTrait;
    public $data = [];

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['positions'] = Position::all();
        $this->data['content'] = 'position/index';
    }

    public function newAction()
    {   
        $this->data['content'] = 'position/new';
    }

    public function createAction(Request $request)
    {
        $post = $request->getPost();

        $name = $post->get('name');
        $description = $post->get('description');

        $query = Position::getBy('name', '=', $name);
        $numRows = count($query);

        if ($numRows == 1) {
            $this->data['error'] = showError('existed');
            $this->data['content'] = '/position/new';
            View::render('admin/back-layouts/master.php', $this->data);
        } else {
            try {
                Position::create(['name' => $name,
                                'description' => $description]);
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };

            header('Location: /admin/index');
            exit;
        }
 
    }

    public function editAction(Request $request)
    {   
        $id = $request->getGet()->get('id');

        $this->data['position'] = Position::getById($id, 'id, name, description');
        $this->data['content'] = 'position/edit';
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = $get->get('id');
        $name = $get->get('name');
        $description = $get->get('description');

        try {
            Position::update(['name' => $name,
                          'description' => $description]
                          , "id = $id");
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };

        header('Location: /admin/index');
        exit;
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        try {
            Position::destroy("id = $id");
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
        
        header('Location: /admin/index');
        exit;
    }
}
