<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class ExamController extends Controller
{
    public array $data;

    protected function after() 
    {
        View::render('admin/back-layouts/master.php', $this->data);
    }
    
    public function listAction()
    {
        $this->data['content'] = 'exam/list';
    }

    public function newAction()
    {
        $this->data['content'] = 'exam/new';
    }
}
