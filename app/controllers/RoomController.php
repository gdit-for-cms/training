<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
// use App\models\Role;
use App\models\Room;
use Core\Http\Session;
use Core\Http\Request;

class RoomController extends Controller
{
    public $data = [];

    protected function before()
    {
        if (!checkUser()) {
            header('Location: /default/index');
            exit;
        }
    }

    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data);
    }

    public function indexAction()
    {   
        $this->data['allUsers'] = User::getAll();

        $this->data['rooms'] = Room::All();

        $this->data['content'] = 'room/index';
    }

    public function newAction()
    {   
        $this->data['content'] = 'room/new';
    }

    public function createAction(Request $request)
    {
        $post = $request->getPost();

        $name = $post['name'];
        $description = $post['description'];

            $room = new Room();
            $room->insert(['name' => $name,
                           'description' => $description]);
            
            header('Location: /admin/index');
            exit;
 
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


        $room = new Room();
        $room->update(['name' => $name,
                       'description' => $description]
                        , "id = $id");

        header('Location: /admin/index');
        exit;
    }

    public function deleteAction(Request $request)
    {
        $id = $request->getGet()['id'];

        $room = new Room();
        $room->destroy("id = $id");
        
        header('Location: /admin/index');
        exit;
    }
}