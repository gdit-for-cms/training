<?php

namespace App\Controllers;

use Core\View;
use Core\Http\Request;

class HomeController extends AppController {
    public $title = 'Home';

    public array $data_ary;

    public function indexAction() {
        $this->data_ary['content'] = '/home/homepage';
    }
}
