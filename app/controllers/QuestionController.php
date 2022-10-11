<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class QuestionController extends Controller
{
    public array $data;
    
    protected function after() 
    {
        View::render('admin/back-layouts/master.php', $this->data);
    }
    
    public function listAction()
    {
        $this->data['content'] = 'question/list';
    }
}
