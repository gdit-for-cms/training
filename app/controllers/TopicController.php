<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class TopicController extends Controller
{
    public $data = [];
    /**
     * Show the index page
     *
     * @return void
     */

    
    public function list()
    {
        $this->data['content'] = 'topic/list';
        View::render('admin/back-layouts/master.php',$this->data);

    }

    public function create()
    {
        $this->data['content'] = 'topic/create';
        View::render('admin/back-layouts/master.php',$this->data);

    }

    
    
}