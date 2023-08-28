<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use App\models\Answer;
use App\Requests\AppRequest;
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

    protected function after()
    {
        // View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function indexAction()
    {
        $this->data_ary['questions'] = $this->obj_model->getAll();
        $this->data_ary['answers'] = Answer::getAll();
        $this->data_ary['content'] = 'question/index';
    }

    public function newAction()
    {
        // $array = array_diff(scandir('../app/controllers/User'), array('..', '.'));
        // $result = array();
        // foreach ($array as $filename) {
        //     array_push($result, strtolower((preg_split('/(?=[A-Z])/', $filename)[1])));
        // }
        // $this->data_ary['pages'] = $result;

        $this->data_ary['content'] = 'question/new';
    }

    public function create(Request $request)
    {
        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $content = $result_vali_ary['content'];
        $title = $result_vali_ary['title'];

        $question_check_ary = $this->obj_model->getBy('content', '=', $content);
        $num_rows = count($question_check_ary);

        if ($num_rows == 1) {
            return $this->errorResponse('Question has been exist');
        } else {
            try {
                $this->obj_model->create(
                    [
                        'title' => $title,
                        'content' => $content,
                    ]
                );
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
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
        $question_id = $request->getGet()->get('question_id');

        $rule = $this->obj_model->getBy('question_id', '=', $question_id, '*');
        if ($rule) {
            return $this->responseShowRule(true, $rule);
        } else {
            return $this->responseShowRule(false);
        }
    }
}
