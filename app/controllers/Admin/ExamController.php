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

    public function indexAction()
    {
        $this->data_ary['examsWithQuestions'] = $this->obj_model->getExamsWithQuestions();
        $this->data_ary['content'] = 'exam/index';
    }

    public function insert(Request $request)
    {
        $exams = $this->obj_model->getAll();
        $exam_title = $request->getPost()->get('title');
        $exam_description = $request->getPost()->get('description');
        foreach ($exams as $exam) {
            $check_exam = strcasecmp($exam['title'], $exam_title);
            if ($check_exam == 0) {
                return $this->errorResponse('Exam has been exist');
            }
        }
        try {
            $this->obj_model->insert([
                'title' => $exam_title,
                'description' => $exam_description
            ]);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
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

        //dựa vào method get lay exam_id
        $exam_id = $request->getGet()->get('exam_id');

        //get exam dua vao exam_id
        $exam =  $this->obj_model->getById($exam_id);

        $questions = $this->obj_model_question->getAll();
        $answers = $this->obj_modal_answer->getAll();

        // $exam_question = $this->obj_model_exam_question->getBy('')
        $exam_questions = $this->obj_model_exam_question->getBy('exam_id', '=', $exam_id, '*');

        // Lấy danh sách các question_id đã tồn tại trong exam_questions
        $existing_question_ids = array_column($exam_questions, 'question_id');

        // Loại bỏ các câu hỏi đã tồn tại trong mảng exam_questions khỏi mảng questions
        $questions = array_filter($questions, function ($question) use ($existing_question_ids) {
            return !in_array($question['id'], $existing_question_ids);
        });

        // Chuyển mảng kết quả về dạng danh sách các câu hỏi
        $questions = array_values($questions);

        $this->data_ary['questions'] = $questions;
        $this->data_ary['answers'] = $answers;
        $this->data_ary['exam'] = $exam;

        $this->data_ary['content'] = "exam/create";
    }

    public function storeAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $exam =  $this->obj_model->getById($exam_id);

        $question_answers = $request->getPost();
        $question_id = $question_answers->get('question_id');
        $answer_ids = $question_answers->get('selected_answers');

        // Lấy danh sách answer_id hiện có trong cơ sở dữ liệu
        foreach ($answer_ids as $answer_id) {
            // Thêm mới answer có answer_id vào cơ sở dữ liệu
            $this->obj_model_exam_question->insert([
                'exam_id' => $exam_id,
                'answer_id' => $answer_id,
                'question_id' => $question_id
            ]);
        }
    }
    public function priviewAction(Request $request)
    {
        //dựa vào method get lay exam_id
        $exam_id = $request->getGet()->get('exam_id');

        //get exam dua vao exam_id
        $exam =  $this->obj_model->getById($exam_id);

        //lay ra cac exam_question dua vao exam_id
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
        $this->data_ary['content'] = "exam/preview";
    }

    public function exportAction(Request $request)
    {
        $this->data_ary['content'] = "exam/export";

        // $this->data_ary['content'] = "exam/export_file";
    }
}
