<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Position;
use Core\Http\Request;

class PositionController extends Controller
{
    public $data = [];

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAllRelation();
        $this->data['positions'] = Position::allPosition();
        $this->data['content'] = 'position/index';
    }

    public function newAction()
    {   
        $this->data['content'] = 'position/new';
    }

    public function createAction(Request $request)
    {
        $post = $request->getPost();

        $name = $post['name'];
        $description = $post['description'];

        $position = new Position();
        $query = $position->table('position')->where('name', '=', $name)->get();
        $numRows = count($query);

        if ($numRows == 1) {
            $this->data['error'] = showError('existed');
            $this->data['content'] = '/position/new';
            View::render('admin/back-layouts/master.php', $this->data);
        } else {
            $position->insert(['name' => $name,
                               'description' => $description]);
            header('Location: /admin/index');
            exit;
        }
 
    }

    public function editAction(Request $request)
    {   
        $id = $request->getGet()['id'];

        $room = new User();
        $this->data['room'] = $room->table('room')->find($id, 'id, name, description');

        $this->data['content'] = 'room/edit';
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = $get['id'];
        $name = $get['name'];
        $description = $get['description'];

        $room = new Position();
        $room->update(['name' => $name,
                       'description' => $description]
                        , "id = $id");

        header('Location: /admin/index');
        exit;
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()['id'];

        $room = new Position();
        $room->destroy("id = $id");
        
        header('Location: /admin/index');
        exit;
    }
}
