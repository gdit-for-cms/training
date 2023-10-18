<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use App\models\Answer;
use Core\Http\ResponseTrait;

class AnswerController extends  AppController
{
    use ResponseTrait;

    public $title = "Answer";

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Answer;
    }
}
