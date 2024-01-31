<?php

namespace App\Controllers;

use Core\Controller;
use Core\Http\Request;
use Core\View;

class AppController extends Controller {
    public $title = 'Home';

    public array $data_ary;

    protected function before() {
        if (!isLogged()) {
            header('Location: /auth/login');
            exit;
        }

        $request = new Request;
        $user = $request->getUser();
        $current_user = [
            'id' => $user['id'],
            'name' => $user['name'],
            'display_name' => $user['display_name'],
            'img' => $user['img'],
        ];

        $this->data_ary['current_user'] = $current_user;
        $this->data_ary['title'] = $this->title;
    }


    protected function after() {
        View::render('/layouts/master.php', $this->data_ary);
    }
}
