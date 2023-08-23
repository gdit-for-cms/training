<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use App\models\Question;
use App\models\Answer;

class QuestionController extends  AppController
{
    public $title = "Question";

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Question;
    }

    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function indexAction()
    {
        $this->data_ary['questions'] = $this->obj_model->getAll();
        $this->data_ary['answers'] = Answer::getAll();
        $this->data_ary['content'] = 'question/list';
        
    }

    public function newAction()
    {
        $array = array_diff(scandir('../app/controllers/User'), array('..', '.'));
        $result = array();
        foreach ($array as $filename) {
            array_push($result, strtolower((preg_split('/(?=[A-Z])/', $filename)[1])));
        }
        $this->data_ary['pages'] = $result;

        $this->data_ary['content'] = 'question/new';
    }
}
