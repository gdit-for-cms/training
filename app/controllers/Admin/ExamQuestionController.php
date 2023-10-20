<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use Core\View;
use App\models\Exam;
use App\Models\Question;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\Models\ExamQuestion;
use App\Models\Answer;
use App\Models\QuestionTitle;
use Core\Http\Config;

class ExamQuestionController extends AppController
{
    use ResponseTrait;

    use Config;

    public $title = 'Exam';

    public object $obj_model;

    public array $data_ary;

    public object $obj_model_question;

    public object $obj_model_exam_question;

    public object $obj_model_answer;

    public object $obj_model_question_title;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_model_answer = new Answer;
        $this->obj_model_question_title = new QuestionTitle;
    }

    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }

    public function newAction(Request $request)
    {
        $req_method_ary = $request->getGet();
        $exam_id = $req_method_ary->get('exam_id');
        $results_ary = $this->obj_model_question_title->getAll();
        $this->data_ary['question_titles'] = $results_ary;
        $this->data_ary['exam_id'] = $exam_id;
        $this->data_ary['content'] = 'exam_question/new';
    }

    public function store(Request $request)
    {
        try {
            $req_method_ary = $request->getPost();
            $question_ids = $req_method_ary->get('array_select_question');
            $exam_id = $req_method_ary->get('exam_id');
            foreach ($question_ids as $question_id) {
                $this->obj_model_exam_question->create([
                    'question_id' => $question_id,
                    'exam_id' => $exam_id,
                ]);
            }
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse(false);
        }
    }

    public function showAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        if ($exam) {
            return $this->successResponse();
        } else {
            return $this->errorResponse(false);
        }
    }

    public function createAction(Request $request)
    {
        $this->data_ary['content'] = "exam/new_question";
    }

    public function deleteQuestionAllAction(Request $request)
    {
        $question_ids = $request->getPost()->get('ids');
        $exam_id = $request->getGet()->get('exam_id');
        foreach ($question_ids as $question_id) {
            $this->obj_model_exam_question->destroyBy("question_id = $question_id and exam_id = $exam_id");
        }
    }
}
