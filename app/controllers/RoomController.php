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

    public function newAction()
    {   

        $this->data['mainContainer'] = 'room/new.php';
        View::render('admin-layout/master.php', $this->data);
        
    }

    public function createAction(Request $request)
    {
        $post = $request->getPost();

        $name = htmlspecialchars(addslashes($post['name']));
        $description = htmlspecialchars(addslashes($post['description']));
        
        $room = new Room();
        $room->insert(['name' => $name,
                       'description' => $description]);
        
        header('Location: /admin/index');
        exit;
 
    }

    public function editAction(Request $request)
    {   
        $id = $request->getGet()['id'];

        $room = new Room();
        $this->data['room'] = $room->table('room')->find($id, 'id, name, description');

        $this->data['mainContainer'] = 'room/edit.php';
        View::render('admin-layout/master.php', $this->data);
    }

    public function updateAction(Request $request)
    {
        $get = $request->getGet();

        $id = htmlspecialchars(addslashes($get['id']));
        $name = htmlspecialchars(addslashes($get['name']));
        $description = htmlspecialchars(addslashes($get['description']));


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