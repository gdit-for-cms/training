<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class DefaultController extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::render('default/index.php');
    }
}
