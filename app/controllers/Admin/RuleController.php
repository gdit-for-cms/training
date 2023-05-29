<?php

namespace App\Controllers\Admin;

use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\models\Rule;


class RuleController extends AppController
{
    use ResponseTrait;

    public $title = 'Rules';

    public object $obj_model;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_model = new Rule;
    }

    public function indexAction(Request $request)
    {

        $this->data_ary['content'] = "rule/index";
    }

    public function rulesDetailAction(Request $request)
    {
        $rules_by_type_ary = $this->obj_model->getBy('type_rule', '=', 'php', '*');

        $this->data_ary['rules_by_type_ary'] = $rules_by_type_ary;
        $this->data_ary['content'] = "rule/detail";
    }
    public function importAction(Request $request)
    {
        if (isset($_FILES['file_upload'])) {
            var_dump($_FILES['file_upload']);
            die;
        }

        $this->data_ary['content'] = "rule/index";
    }
}
