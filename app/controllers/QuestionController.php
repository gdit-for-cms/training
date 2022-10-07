<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class QuestionController extends Controller
{
    public $data = [];
    /**
     * Show the index page
     *
     * @return void
     */

    
    public function list()
    {
        $this->data['content'] = 'question/list';
        View::render('admin/back-layouts/master.php',$this->data);

    }

    
    
}