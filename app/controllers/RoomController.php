<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class RoomController extends Controller
{   
    use ResponseTrait;
    public array $data;

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['rooms'] = Room::all();
        $this->data['content'] = 'room/index';
    }

    public function newAction()
    {   
        $this->data['content'] = 'room/new';
    }

    public function createAction(Request $request)
    {
        $post = $request->getPost();

        $name = $post->get('name');
        $description = $post->get('description');

        try {
            Room::create(['name' => $name,
                        'description' => $description]);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    
        header('Location: /admin/index');
        exit;
    }

    public function editAction(Request $request)
    {   
        $id = $request->getGet()->get('id');

        $this->data['room'] = Room::getById($id, 'id, name, description');
        $this->data['content'] = 'room/edit';
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = $get->get('id');
        $name = $get->get('name');
        $description = $get->get('description');
        
        try {
            Room::update(['name' => $name,
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
            Room::destroy("id = $id");
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
        
        header('Location: /admin/index');
        exit;
    }
}
