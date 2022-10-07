<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class ExamController extends Controller
{
    public $data = [];
    /**
     * Show the index page
     *
     * @return void
     */

    
    public function list()
    {
        $this->data['content'] = 'exam/list';
        View::render('admin/back-layouts/master.php',$this->data);

    }

    public function create()
    {
        $this->data['content'] = 'exam/create';
        View::render('admin/back-layouts/master.php',$this->data);

    }

    
    
}