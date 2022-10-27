<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class HomeController extends Controller
{
    public $data =[] ;
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {
        View::render('default/index.php1');
    }
}
