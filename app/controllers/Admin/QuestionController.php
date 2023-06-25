<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\Controller;
use Core\View;
use Core\Http\Request;

class QuestionController extends AppController {
    public $title = "Question";
    public array $data_ary;

    protected function after() {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function indexAction() {
        $this->data_ary['content'] = 'question/list';
    }
}