<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use App\Requests\AppRequest;
use App\models\Exam;
use App\Models\Question;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\Models\ExamQuestion;
use App\Models\Answer;
use App\Config;

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

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
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

    public function examDetailAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $exam =  $this->obj_model->getById($exam_id);
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

    // add question to the exam
    public function createAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');

        $exam =  $this->obj_model->getById($exam_id);
        $questions = $this->obj_model_question->getAll();
        $answers = $this->obj_modal_answer->getAll();
        $exam_questions = $this->obj_model_exam_question->getBy('exam_id', '=', $exam_id, '*');

        // Get the list of question_ids that already exist in exam_questions
        $existing_question_ids = array_column($exam_questions, 'question_id');

        //Remove questions that already exist in the exam questions array from the questions array
        $questions = array_filter($questions, function ($question) use ($existing_question_ids) {
            return !in_array($question['id'], $existing_question_ids);
        });

        // Convert the result array to a list of questions
        $questions = array_values($questions);

        $this->data_ary['questions'] = $questions;
        $this->data_ary['answers'] = $answers;
        $this->data_ary['exam'] = $exam;

        $this->data_ary['content'] = "exam/create";
    }

    public function store(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
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
        return $this->successResponse();
    }

    //show preview exam
    public function previewAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $exam =  $this->obj_model->getById($exam_id);
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
    }

    public function uploadAction(Request $request)
    {
        $ftp_server = Config::FTP_SERVER;
        $ftp_username = Config::FTP_USERNAME;
        $ftp_password = Config::FTP_PASSWORD;
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $your_server_directory = Config::YOUR_SERVER_DIRECTORY;

        $ftp_connection = ftp_connect($ftp_server);
        $login = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        $html_content = $request->getPost()->get('html_content');
        $csv_content = $request->getPost()->get('csv_content');

        $file_name = 'exam232';
        $full_new_directory = $your_server_directory . $file_name;
        $your_server_directory_html = $full_new_directory . '.html';
        $your_server_directory_csv = $full_new_directory . '.csv';

        if ($ftp_connection && $login) {
            // upload files to my server
            $check_put_html = file_put_contents($your_server_directory_html, $html_content);
            $check_put_csv = file_put_contents($your_server_directory_csv, $csv_content);

            if ($check_put_html !== false && $check_put_csv !== false) {
                //upload files from your server to the server that needs to store the files
                $upload_html = ftp_put($ftp_connection, $html_directory . basename($your_server_directory_html), $your_server_directory_html, FTP_BINARY);
                $upload_csv = ftp_put($ftp_connection, $csv_directory . basename($your_server_directory_csv), $your_server_directory_csv, FTP_BINARY);

                unlink($your_server_directory_html);
                unlink($your_server_directory_csv);
                if (!$upload_html && !$upload_csv) {
                    die("Cann't upload");
                }
            } else {
                echo "failed.";
            }
            ftp_close($ftp_connection);
        }
    }

    public function editAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        $this->data_ary['exam'] = $exam;
        $this->data_ary['content'] = "exam/edit";
    }

    public function update(Request $request)
    {
        $post_ary = $request->getPost()->all();
        try {
            $id = $post_ary['id'];
            $title = $post_ary['title'];
            $description = $post_ary['description'];

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

    public function deleteAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $this->obj_model->destroyBy("id = $exam_id");
    }

    public function detailDeleteAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $this->obj_model_exam_question->destroyBy("question_id = $exam_id");
    }

    public function detailEditAction(Request $request)
    {
        $question_id = $request->getGet()->get('question_id');
        $exam_id =  $request->getGet()->get('exam_id');

        $exam_questions = $this->obj_model_exam_question->getExamQuestionByIds($exam_id, $question_id, '*');
        $question = $this->obj_model_question->getById($question_id);
        $answers = $this->obj_modal_answer->getBy('question_id', '=', $question_id, '*');

        $this->data_ary['exam_questions'] = $exam_questions;
        $this->data_ary['question'] = $question;
        $this->data_ary['answers'] = $answers;
        $this->data_ary['content'] = "exam/detail_edit";
    }
}
