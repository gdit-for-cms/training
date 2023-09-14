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

    public object $app_request;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_modal_answer = new Answer;
        $this->app_request = new AppRequest;
    }

    public function indexAction(Request $request)
    {
        $file = 'exam';
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $directory['html'] = $html_directory . $file;
        $directory['csv'] = $csv_directory . $file;
        $directory['domain'] = Config::FTP_DOMAIN  . $file;
        $this->data_ary['directory'] = $directory;
        // $this->data_ary['exams'] = $this->obj_model->getAll();





        // pagination
        // $exam_id = $request->getGet()->get('exam_id');
        // $req_method_ary['exam_id'] = $exam_id;
        $req_method_ary = $request->getGet()->all();
        $results_per_page = 5;
        $results_ary = $this->obj_model->getExam($req_method_ary, $results_per_page);

        

        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];
        $this->data_ary['exams'] = $results_ary['results'];

        // echo "<pre>";
        // var_dump($this->data_ary['exams']);
        // die();

        $this->data_ary['content'] = 'exam/index';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
    }

    public function insert(Request $request)
    {

        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $exam_title = $result_vali_ary['title'];
        $exam_description =  $result_vali_ary['description'];
        $exam_duration = $result_vali_ary['duration'];

        $exams = $this->obj_model->getAll();
        foreach ($exams as $exam) {
            $check_exam = strcasecmp($exam['title'], $exam_title);
            if ($check_exam == 0) {
                return $this->errorResponse('Exam has been exist');
            }
        }
        try {
            $this->obj_model->insert([
                'title' => $exam_title,
                'description' => $exam_description,
                'published' => 0,
                'duration' => $exam_duration

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
        $req_method_ary = $request->getGet()->all();
        $req_method_ary['exam_id'] = $exam_id;
        $results_per_page = 5;
        $results_ary = $this->obj_model->getDetailExams($req_method_ary, $results_per_page);

        $this->data_ary['question_answers'] = $results_ary['results'];
        $this->data_ary['exam'] = $exam;
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];

        $this->data_ary['content'] = 'exam/detail';
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

        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);


        $file_name = "exam" . $exam_id;
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
            $this->obj_model->updateOne(
                [
                    'published' => 1,
                ],
                "id = $exam_id"
            );
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

        $exam_check_ary = $this->obj_model->getBy('title', '=', $post_ary['title']);
        $num_rows = count($exam_check_ary);

        $id = $post_ary['id'];
        $title = $post_ary['title'];
        $description = $post_ary['description'];
        $duration = $post_ary['duration'];
        if ($num_rows > 0 && $exam_check_ary[0]['id'] != $id) {
            return $this->errorResponse('Exam has been exist');
        }

        try {
            $this->obj_model->updateOne(
                [
                    'title' => $title,
                    'description' => $description,
                    'duration' => $duration
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
        $this->data_ary['exam_id'] = $exam_id;
        $this->data_ary['content'] = "exam/detail_edit";
    }

    public function editDetailExamAction(Request $request)
    {

        $post_ary = $request->getPost();
        $exam_id =  $post_ary->get('exam_id');
        $question_id =  $post_ary->get('question_id');
        $answer_ids =  $post_ary->get('selected_answer');

        $this->obj_model_exam_question->destroyBy('question_id' . '=' . $question_id . ' and ' . 'exam_id' . '=' . $exam_id);

        foreach ($answer_ids as $answer_id) {
            $this->obj_model_exam_question->insert([
                'exam_id' => $exam_id,
                'answer_id' => $answer_id,
                'question_id' => $question_id
            ]);
        }

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
}
