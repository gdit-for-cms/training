<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;
use Core\Http\Request;

class UserController extends AppController {
    public array $data_ary;

    protected function before() {
        if (isRegisterURL()) {
            header('Location: /user/register');
            exit;
        }
    }

    public function registerAction() {
        View::render('home/register.php');
    }

    public function registerProcessAction() {
        $regis_user = new User;
    }

    protected function after() {
    }
}
