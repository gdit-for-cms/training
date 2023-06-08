<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\Controller;
use Core\View;

class ExamController extends AppController
{
    public array $data_ary;

    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function indexAction()
    {
        $this->data_ary['content'] = 'exam/list';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
    }
}
