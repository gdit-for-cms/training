<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class TopicController extends Controller
{
    public $data = [];

    public function listAction()
    {
        $this->data['content'] = 'topic/list';
    }

    public function newAction()
    {
        $this->data['content'] = 'topic/new';
    }

    
    
}