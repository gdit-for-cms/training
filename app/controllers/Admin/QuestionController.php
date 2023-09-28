<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use Core\Http\Request;
use App\models\Question;
use App\models\Answer;
use App\Models\QuestionTitle;
use App\Requests\AppRequest;
use Core\Http\ResponseTrait;

class QuestionController extends  AppController
{
    use ResponseTrait;

    public $title = "Question";

    public array $data_ary;

    public object $obj_model;

    public object $obj_model_answer;

    public object $app_request;

    public object $obj_model_question_title;

    public function __construct()
    {
        $this->obj_model = new Question;
        $this->obj_model_answer = new Answer;
        $this->obj_model_question_title = new QuestionTitle;
        $this->app_request = new AppRequest;
    }

    public function indexAction(Request $request)
    {

        $req_method_ary = $request->getGet()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model_question_title->getAllHasPagination($req_method_ary, $results_per_page);
        $this->data_ary['question_titles'] = $results_ary['results'];
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];

        $this->data_ary['content'] = 'question/index';
    }

    public function newAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $question_title_id = $req_method_ary['ques-title'];
        $question_title = $this->obj_model_question_title->getById($question_title_id, 'id, title, description');
        $this->data_ary['question_title'] = $question_title;
        $this->data_ary['content'] = 'question/new';
    }

    public function check_enter_answer($answers)
    {
        foreach ($answers as $answer) {
            if (strlen(trim($answer)) == 0) {
                return false;
            }
        }
        return true;
    }

    public function check_unique_answer($answers)
    {
        if (count($answers) > count(array_unique($answers))) {
            return false;
        }
        return true;
    }

    public function create(Request $request)
    {
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        $content = $result_vali_ary['content'];
        $question_title_id = $result_vali_ary['question_title_id'];
        $answers =  $result_vali_ary['answer'];

        if (!$this->check_enter_answer($answers)) {
            return $this->errorResponse("You need to enter the answer.");
        }
        if (!$this->check_unique_answer($answers)) {
            return $this->errorResponse("Answers cannot be duplicated.");
        }

        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("You need to choose at least one correct answer.");
        }
        $is_corrects = $result_vali_ary['is_correct'];
        $question_check_ary = $this->obj_model->getBy('content', '=', $content);
        $num_rows = count($question_check_ary);
        if ($num_rows > 0) {
            return $this->errorResponse('Question has been exist');
        } else {
            try {
                // $this->obj_model->beginTransaction();
                $questionId = $this->obj_model->create(
                    [
                        'content' => $content,
                        'question_title_id' => $question_title_id
                    ]
                );
                $question = $this->obj_model->getBy("content","=",$content);
                foreach ($answers as $index => $answerContent) {
                    $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                    $this->obj_model_answer->create(
                        [
                            'question_id' => $question[0]['id'],
                            'content' => $answerContent,
                            'is_correct' => $isCorrect,
                        ]
                    );
                }
                // $this->obj_model->commitTransaction();
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('question_id');
        $this->data_ary['question'] = $this->obj_model->getById($id, 'id, content');
        $this->data_ary['answers'] = $this->obj_model_answer->getBy('question_id', '=', $id);

        $this->data_ary['content'] = 'question/edit';
    }

    public function deleteAction(Request $request)
    {
        $question_id = $request->getGet()->get('id');
        $this->obj_model->destroyBy("id = $question_id");
    }

    public function update(Request $request)
    {
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        $content = $result_vali_ary['content'];
        $answers =  $result_vali_ary['answer'];
        $question_id = $request->getPost()->get('id');

        if (!$this->check_enter_answer($answers)) {
            return $this->errorResponse("You need to enter the answer.");
        }

        if (!$this->check_unique_answer($answers)) {
            return $this->errorResponse("Answers cannot be duplicated.");
        }

        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("You need to choose at least one correct answer");
        }

        $is_corrects = $result_vali_ary['is_correct'];
        $question_check_ary = $this->obj_model->getBy('content', '=', $content);
        $num_rows = count($question_check_ary);

        if ($num_rows > 0 && $question_check_ary[0]['id'] != $question_id) {
            return $this->errorResponse('Question has been exist');
        } else {

            try {
                // $this->obj_model->beginTransaction();
                $this->obj_model->updateOne(
                    [
                        'content' => $content
                    ],
                    "id = $question_id"
                );

                $this->obj_model_answer->destroyBy("question_id = $question_id");
                // Insert các answer dựa vào questionId và vị trí đúng
                foreach ($answers as $index => $answerContent) {
                    $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                    $this->obj_model_answer->create(
                        [
                            'question_id' => $question_id,
                            'content' => $answerContent,
                            'is_correct' => $isCorrect,
                        ]
                    );
                }
                // $this->obj_model->commitTransaction();
                return $this->successResponse();
            } catch (\Throwable $th) {

                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function detailAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $results_per_page = 5;
        $results_ary = $this->obj_model->getAllRelation($req_method_ary, $results_per_page);
        $this->data_ary['question_titles'] = $results_ary['results'];
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];
        $question_title_id = $req_method_ary['question_id'];
        $this->data_ary['question_title'] = $this->obj_model_question_title->getById($question_title_id, "title,description");

        $this->data_ary['content'] = 'question/detail';
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

    public function searchAction(Request $request)
    {
        $req_method_ary = $request->getPost()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model_question_title->getAllHasPagination($req_method_ary, $results_per_page);

        return $this->responseShowRule(200, $results_ary);
    }
}
