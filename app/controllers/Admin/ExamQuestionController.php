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

    public function indexAction()
    {
        $this->data_ary['examsWithQuestions'] = $this->obj_model->getExamsWithQuestions();
        $this->data_ary['content'] = 'exam/index';
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

    public function showAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        if ($exam) {
            return $this->successResponse();
            // return $this->successResponse(true, $exam);
        } else {
            return $this->errorResponse(false);
        }
    }

    public function examDetailAction(Request $request)
    {
        //dựa vào method get lay exam_id
        $exam_id = $request->getGet()->get('exam_id');

        //get exam dua vao exam_id
        $exam =  $this->obj_model->getById($exam_id);

        //lay ra cac exa,_question dua vao exam_id
        $exam_questions = $this->obj_model_exam_question->getBy('exam_id', '=', $exam_id, '*');

        $question_answers = array();

        foreach ($exam_questions as $exam_question) {

            $question_id = $exam_question['question_id'];

            if (!isset($question_answers[$question_id])) {
                $question_answers[$question_id] = array(
                    'question' => $this->obj_model_question->getById($question_id),
                    'answers' => array()
                );
            }

            $answer_id = $exam_question['answer_id'];
            $answer_info = $this->obj_model_answer->getById($answer_id);

            // Thêm thông tin câu trả lời vào mảng answers
            $question_answers[$question_id]['answers'][] = $answer_info;
        }
        $this->data_ary['question_answers'] = $question_answers;
        $this->data_ary['exam'] = $exam;
        $this->data_ary['content'] = "exam/detail";
    }

    public function createAction(Request $request)
    {
        $this->data_ary['content'] = "exam/new_question";
    }

    // public function new_question(Request $request)
    // {
    //     $this->data_ary['content'] = "exam/new";
    // }
}
