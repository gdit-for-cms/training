<?php

namespace App\Controllers;

use Core\Controller;
use Core\Http\Request;
use Core\View;

class AppController extends Controller {
    public $title = 'App';

    public array $data_ary;

    protected function before() {
        if (!isLogged()) {
            header('Location: /auth/login');
            exit;
        }

        $request = new Request;
        $user = $request->getUser();
        $cur_user = [
            // 
        ];

        $this->data_ary['cur_user'] = $cur_user;
        $this->data_ary['title'] = $this->title;
    }


    protected function after() {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }
}
