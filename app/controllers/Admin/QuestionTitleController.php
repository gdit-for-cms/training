<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use Core\Http\Request;
use App\models\Question;
use App\models\Answer;
use App\Models\QuestionTitle;
use App\Requests\AppRequest;
use Core\Http\ResponseTrait;

class QuestionTitleController extends  AppController
{
    use ResponseTrait;

    public $title = "Question";

    public array $data_ary;

    public object $obj_model;

    public object $obj_model_answer;

    public object $app_request;

    public function __construct()
    {
        $this->obj_model = new QuestionTitle;
        $this->obj_model_answer = new Answer;
        $this->app_request = new AppRequest;
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'question_title/new';
    }

    public function create(Request $request)
    {
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }


        $title = $result_vali_ary['title'];
        $description = $result_vali_ary['description'];

        $question_titles = $this->obj_model->getAll();
        foreach ($question_titles as $question_title) {
            $check_exam = strcasecmp($question_title['title'], $title);
            if ($check_exam == 0) {
                return $this->errorResponse('Question collection has been exist');
            }
        }

        try {
            $this->obj_model->create(
                [
                    'title' => $title,
                    'description' => $description
                ]
            );

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function deleteAction(Request $request)
    {
        $question_id = $request->getGet()->get('id');
        $this->obj_model->destroyBy("id = $question_id");
    }
}
