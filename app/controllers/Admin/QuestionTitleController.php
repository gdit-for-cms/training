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

    public object $obj_model_question;

    public object $app_request;

    public function __construct()
    {
        $this->obj_model = new QuestionTitle;
        $this->obj_model_answer = new Answer;
        $this->app_request = new AppRequest;
        $this->obj_model_question = new Question;
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
        $title = htmlspecialchars($result_vali_ary['title']);
        $description = htmlspecialchars($result_vali_ary['description']);
        $question_titles = $this->obj_model->getBy('title', '=', $title);
        if (count($question_titles) > 0) {
            return $this->errorResponse('Question collection has been exist');
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
        if ($question_id == "null") {
            $this->obj_model_question->destroyBy("question_title_id is $question_id");
        } else if ($question_id == "select") {
            $ids = $request->getPost()->get('ids');
            foreach ($ids as $id) {
                $this->obj_model->destroyBy("id = $id");
            }
        } else {
            $this->obj_model->destroyBy("id = $question_id");
        }
    }

    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('ques-title');

        $this->data_ary['question_title'] = $this->obj_model->getById($id, "id,title,description");
        $this->data_ary['content'] = 'question_title/edit';
    }

    public function update(Request $request)
    {
        $post_ary = $request->getPost()->all();
        $check_exam = $this->obj_model->getById($post_ary['id']);
        $change_data_flg = false;
        foreach ($post_ary as $key => $value) {
            if ($check_exam[$key] != $value) {
                $change_data_flg = true;
                break;
            }
        }
        if (!$change_data_flg) {
            return $this->errorResponse('Nothing to update');
        }
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        $title = $result_vali_ary['title'];
        $description = $result_vali_ary['description'];
        $ques_title_check_ary = $this->obj_model->getBy('title', '=', htmlspecialchars($post_ary['title']));
        $id = $post_ary['id'];
        $title = htmlspecialchars($post_ary['title']);
        $description = htmlspecialchars($post_ary['description']);
        if (count($ques_title_check_ary) > 0 && $ques_title_check_ary[0]['id'] != $id) {
            return $this->errorResponse('Exam has been exist');
        }

        try {
            $this->obj_model->updateOne(
                [
                    'title' => $title,
                    'description' => $description,
                ],
                "id = $id"
            );
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function responseShowRule($status, $result = [])
    {
        $res = [
            "success" => $status,
            "result" => $result
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }

    public function showAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $questions = $this->obj_model_question->getQuestionAnswer($req_method_ary, 'all');
        if ($questions) {
            return $this->responseShowRule(true, $questions);
        } else {
            return $this->responseShowRule(false);
        }
    }
}