<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use App\models\ExamParticipant;
use Core\Http\ResponseTrait;
use Core\Http\Request;

class ExamParticipantController extends  AppController
{
    use ResponseTrait;

    public $title = "exam_participants";

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new ExamParticipant;
    }

    public function deleteAction(Request $request)
    {
        $participant_ids = $request->getGet()->get('id');
        if ($participant_ids == "select") {
            $ids = $request->getPost()->get('ids');
            foreach ($ids as $id) {
                $this->obj_model->destroyBy("id = $id");
            }
        } else {
            $this->obj_model->destroyBy("id = $participant_ids");
        }
    }
}
