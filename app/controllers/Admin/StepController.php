<?php

namespace App\Controllers\Admin;

use App\models\Question;
use App\models\Step;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class StepController extends Controller
{
    use ResponseTrait;

    public $title = 'Create Step';

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Step;
    }

    public function indexAction()
    {
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = 'step/index';
        $this->data_ary['steps'] = $this->obj_model->getAll();
        View::render('admin/step/index.php', $this->data_ary);
        exit;
    }

    public function create(Request $request) {
        $id = $request->getPost()->get('step_id');
        $name = $request->getPost()->get('step_name');
        try {
            $this->obj_model->create(
                [
                    'step_id' => $id,
                    'step_name' => $name,
                ]);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }


    public function deleteAction(Request $request) {
        $id = $request->getPost()->get('step_id');
        try {
            $this->obj_model->destroyOne("step_id = $id");;
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }
}
