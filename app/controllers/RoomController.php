<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
// use App\models\User;
// use App\models\Role;
use App\models\Room;
use Core\Http\Session;
use Core\Http\Request;

class RoomController extends Controller
{
    private $request ;
    public $data = [];
    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();   
    }

    public function newAction()
    {   

        View::render('room/new.php');
        
    }

    public function createAction()
    {
        
        $post = $this->request->getPost();

        $name = htmlspecialchars($post['name']);
        $description = htmlspecialchars($post['description']);
        
        $room = new Room();
        $room->insert(['name' => $name,
                       'description' => $description]);
        
        header('Location: /admin/index');
        exit;
 
    }


    public function editAction()
    {   
        $id = $this->request->getGet()['id'];

        $room = new Room();
        $this->data['room'] = $room->table('room')->find($id, 'id, name, description');

        View::render('room/edit.php', $this->data);
    }

    public function updateAction()
    {
        $get = $this->request->getGet();

        $id = htmlspecialchars($get['id']);
        $name = htmlspecialchars($get['name']);
        $description = htmlspecialchars($get['description']);

        $room = new Room();
        $room->update(['name' => $name,
                       'description' => $description]
                        , "id = $id");
                        
        header('Location: /admin/index');
        exit;
    }

    public function deleteAction()
    {
        $id = $this->request->getGet()['id'];

        $room = new Room();
        $room->destroy("id = $id");
        
        header('Location: /admin/index');
        exit;
    }
}