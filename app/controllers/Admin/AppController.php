<?php

namespace App\Controllers\Admin;

use App\Models\Permission;
use App\Models\Room;
use Core\Controller;
use Core\Http\Request;
use Core\View;

class AppController extends Controller
{
    public $title = 'App';

    public array $data_ary;

    protected function before()
    {
        if (!checkAuth() || !checkPermission()) {
            header('Location: /admin/auth/login');
            exit;
        }

        $request = new Request;
        $user_room = $request->getUser()['room_id'];
        $permissions_access_ary =  [];
        if (getLevel() == 1) {
            $permissions_access_ary = Permission::getAll();
        } else {
            $permissions_access_ary = Room::getPermissionsAccess($user_room);
        }
        $cur_user = [
            'role_id' => $request->getUser()['role_id'],
            'permissions' => $permissions_access_ary
        ];

        $this->data_ary['cur_user'] = $cur_user;
        $this->data_ary['title'] = $this->title;
    }


    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }
}
