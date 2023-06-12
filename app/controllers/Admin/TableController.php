<?php

namespace App\Controllers\Admin;

use App\models\Question;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class TableController extends Controller {

    public $title = 'Create Table';
    
    public array $data_ary;

    public object $obj_model;

    public function __construct() {
        $this->obj_model = new Question;
    }

    public function indexAction() {   
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = 'table/index';
        $this->data_ary['questions'] = $this->obj_model->getQuestionDad();
        View::render('admin/table/index.php', $this->data_ary);
    }
}
