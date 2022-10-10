<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Http\Request;

class QuestionController extends Controller
{
    public $data = [];
    
    protected function before() {
        if (!checkUser()) {
            header('Location: /default/index');
            exit;
        }
    }

    protected function after() {
        View::render('admin/back-layouts/master.php',$this->data);
    }
    
    public function listAction()
    {
        $this->data['content'] = 'question/list';
    }
}