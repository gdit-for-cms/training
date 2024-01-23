<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class RegisterController {
    public array $data_ary;

    public function index() {
        View::render('home/register.php');
    }
}
