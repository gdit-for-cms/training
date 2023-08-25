<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\View;
use App\Requests\AppRequest;
use App\models\Exam;
use App\Models\Question;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ExamController extends AppController
{
    use ResponseTrait;

    public $title = 'Exam';

    public object $obj_model;

    public array $data_ary;

    public object $obj_model_question;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
    }


    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function indexAction()
    {
        // $this->data_ary['exams'] = $this->obj_model->getAll();
        // $this->data_ary['questions'] = $this->obj_model_question->getAll();

        $this->data_ary['examsWithQuestions'] = $this->obj_model->getExamsWithQuestions();
        $this->data_ary['content'] = 'exam/index';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
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
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        if ($exam) {
            return $this->responseShowRule(true, $exam);
        } else {
            return $this->responseShowRule(false);
        }
    }
}
