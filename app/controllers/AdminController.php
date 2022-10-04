<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;

class AdminController extends Controller
{
    private $_table = 'user';
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {   
        
        View::render('default/dashboard.php');
    }

    
}