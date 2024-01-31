<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class UserController extends AppController {
    public array $data_ary;

    public object $current_user;

    public function __construct() {
        $this->current_user = new User;
    }
}
