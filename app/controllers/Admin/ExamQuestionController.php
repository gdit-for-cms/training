<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\View;
use App\Requests\AppRequest;
use App\models\Exam;
use App\Models\Question;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\Models\ExamQuestion;
use App\Models\Answer;

class ExamController extends AppController
{
    use ResponseTrait;

    public $title = 'Exam';

    public object $obj_model;

    public array $data_ary;

    public object $obj_model_question;

    public object $obj_model_exam_question;

    public object $obj_modal_answer;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_modal_answer = new Answer;
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

    public function examDetailAction(Request $request)
    {
        //dựa vào method get lay exam_id
        $exam_id = $request->getGet()->get('exam_id');

        //get exam dua vao exam_id
        $exam =  $this->obj_model->getById($exam_id);


        // $all_categories = $this->obj_rule->getAllCategories($type_rule_id);

        // $get_results_per_page =  $request->getGet()->get('results_per_pages');
        // $results_per_page =  $get_results_per_page ? $get_results_per_page : '5';
        // $options_select_ary = [5, 10, 15];z
        // $get_ary = $request->getGet()->all();
        // array_shift($get_ary);
        // $results_ary = $this->obj_rule->getAllRelation($get_ary, $results_per_page);

        // $numbers_of_result = $results_ary['numbers_of_result'];
        // $numbers_of_pages = ceil($numbers_of_result / $results_per_page);
        // $current_page = (int) $request->getGet()->get('page');
        // $previous_order = ($current_page - 1) * $results_per_page;
        // $max_pagination_item = 4;


        // $this->data_ary['previous_order'] = $previous_order;
        // $this->data_ary['current_page'] = $current_page;
        // $this->data_ary['results_per_page'] = $results_per_page;
        // $this->data_ary['numbers_of_pages'] = $numbers_of_pages;
        // $this->data_ary['numbers_of_result'] = $numbers_of_result;
        // $this->data_ary['options_select_ary'] = $options_select_ary;
        // $this->data_ary['max_pagination_item'] = $max_pagination_item;
        // $this->data_ary['rules_in_one_page_ary'] = $results_ary['results'];
        // $this->data_ary['all_categories'] = $all_categories;


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
            $answer_info = $this->obj_modal_answer->getById($answer_id);

            // Thêm thông tin câu trả lời vào mảng answers
            $question_answers[$question_id]['answers'][] = $answer_info;
        }
        $this->data_ary['question_answers'] = $question_answers;
        $this->data_ary['exam'] = $exam;
        $this->data_ary['content'] = "exam/detail";
    }

    public function createAction(Request $request)
    {
        // $type_rule_id = $request->getGet()->get('type_rule_id');
        // $type_rule = $this->obj_type_rule->getById($type_rule_id);
        // $all_categories = $this->obj_rule->getAllCategories($type_rule_id);
        // $this->data_ary['all_categories'] = $all_categories;
        // $this->data_ary['type_rule'] = $type_rule;
        // $exam_id 
        $this->data_ary['content'] = "exam/new_question";
    }

    public function new_question(Request $request){
        $this->data_ary['content'] = "exam/new";

    }
}
