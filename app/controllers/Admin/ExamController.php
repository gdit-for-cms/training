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
use App\Models\ExamParticipant;
use App\Models\QuestionTitle;

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

    public object $obj_model_exam_participant;

    public object $obj_model_question_title;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_modal_answer = new Answer;
        $this->app_request = new AppRequest;
        $this->obj_model_exam_participant = new ExamParticipant;
        $this->obj_model_question_title = new QuestionTitle;
    }

    public function indexAction(Request $request)
    {
        $file = '';
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $directory['html'] = $html_directory . $file;
        $directory['csv'] = $csv_directory . $file;
        $directory['domain'] = Config::FTP_DOMAIN  . $file;
        $this->data_ary['directory'] = $directory;
        // pagination
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
        $this->data_ary['exam_details'] = $results_ary['results'];

        $this->data_ary['exam'] = $exam;
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];

        $emails = $this->obj_model_exam_participant->getBy("exam_id", '=', $exam_id);
        $this->data_ary['emails'] = $emails;


        // //start add question
        // $req_method_ary = $request->getGet();
        // $exam_id = $req_method_ary->get('exam_id');
        // $results_ary = $this->obj_model_question_title->getAll();
        // $this->data_ary['question_titles'] = $results_ary;
        // //end add question
        $this->data_ary['content'] = 'exam/detail';
    }
    public function checkHasEmail($data)
    {
        if (!isset($data['email'])) {
            return false;
        }
        return true;
    }

    public function create(Request $request)
    {

        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');

        //check has email
        $req_method_ary = $request->getPost()->all();
        $check_has_mail = $this->checkHasEmail($req_method_ary);

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $title = trim($result_vali_ary['title']);
        $description = $result_vali_ary['description'];
        $duration = $result_vali_ary['duration'];
        $question_titles = $this->obj_model->getAll();

        foreach ($question_titles as $question_title) {
            $check_exam = strcasecmp($question_title['title'], $title);
            if ($check_exam == 0) {
                return $this->errorResponse('Exam collection has been exist');
            }
        }


        try {
            $this->obj_model->beginTransaction();

            $this->obj_model->create(
                [
                    'title' => $title,
                    'description' => $description,
                    'duration' => $duration
                ]
            );

            if ($check_has_mail) {
                $email_arrays = $req_method_ary['email'];
                $exam = $this->obj_model->getBy('title', '=', $title);
                $exam_id = $exam[0]['id'];
                $stt_email = 1;
                $arr_check_email = array();
                foreach ($email_arrays as $email) {
                    $email = trim($email);
                    if ($email == "") {
                        return $this->errorResponse("phải điền vào các ô email");
                    }
                    if (!email($email)) {
                        return $this->errorResponse("email số " . $stt_email . " không đúng định dạng");
                    }
                    if (in_array($email, $arr_check_email)) {
                        return $this->errorResponse("email số " . $stt_email . " đã trùng lặp");
                    }
                    $this->obj_model_exam_participant->create([
                        'exam_id' => $exam_id,
                        'email' => $email,
                        'is_login' => 1,
                        'is_submit' => 2
                    ]);
                    array_push($arr_check_email, trim($email));

                    $stt_email++;
                }
            }

            $this->obj_model->commitTransaction();
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    function createEmailExamParticipant($email_arrays, $exam_id)
    {
        $stt_email = 1;
        $arr_check_email = array();
        foreach ($email_arrays as $email) {
            $email = trim($email);
            if ($email == "") {
                return $this->errorResponse("phải điền vào các ô email");
            }
            // $result_vali_ary = $this->app_request->validate($this->obj_model_exam_participant->rules(), $request, 'post');
            if (!email($email)) {
                return $this->errorResponse("email số " . $stt_email . " không đúng định dạng");
            }
            if (in_array($email, $arr_check_email)) {
                return $this->errorResponse("email số " . $stt_email . " đã trùng lặp");
            }
            $this->obj_model_exam_participant->create([
                'exam_id' => $exam_id,
                'email' => $email,
                'is_login' => 1,
                'is_submit' => 2
            ]);
            array_push($arr_check_email, trim($email));

            $stt_email++;
        }
        return true;
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

    public function previewAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $exam =  $this->obj_model->getById($exam_id);
        $exam_questions = $this->obj_model_exam_question->getBy('exam_id', '=', $exam_id, '*');
        $exam_participants = $this->obj_model_exam_participant->getBy('exam_id', '=', $exam_id);
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
        $this->data_ary['exam_participants'] = $exam_participants;

        $this->data_ary['content'] = "exam/preview";
    }

    public function exportAction(Request $request)
    {
        $this->data_ary['content'] = "exam/export";
    }

    public function configFTP()
    {
        $ftp_server = Config::FTP_SERVER;
        $ftp_username = Config::FTP_USERNAME;
        $ftp_password = Config::FTP_PASSWORD;

        $ftp_connection = ftp_connect($ftp_server);
        $login = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        if (!$ftp_connection || !$login) {
            return false;
        }
        return $ftp_connection;
    }
    public function uploadAction(Request $request)
    {
        $check_config = $this->configFTP();
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $your_server_directory = Config::YOUR_SERVER_DIRECTORY;
        $email_directory = Config::FTP_PUBLIC_DIRECTORY_EMAIL;

        $html_content = $request->getPost()->get('html_content');
        $csv_content = $request->getPost()->get('csv_content');
        $csv_exam_participants = $request->getPost()->get('csv_exam_participants');

        // echo $csv_exam_participants;
        // die();

        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);

        // file name csv answer and question html
        $file_name = $exam_id;
        //file email exam participant
        $file_exam_participant = "email" . $exam_id;


        $full_new_directory = $your_server_directory . $file_name;
        $full_new_directory_exam = $your_server_directory . $file_exam_participant;


        $your_server_directory_html = $full_new_directory . '.html';
        $your_server_directory_csv = $full_new_directory . '.csv';
        $your_server_directory_email = $full_new_directory_exam . '.csv';

        if ($check_config) {
            // upload files to my server
            $check_put_html = file_put_contents($your_server_directory_html, $html_content);
            $check_put_csv = file_put_contents($your_server_directory_csv, $csv_content);
            $check_put_csv_exam_participant = file_put_contents($your_server_directory_email, $csv_exam_participants);


            if ($check_put_html !== false && $check_put_csv !== false && $check_put_csv_exam_participant !== false) {
                //upload files from your server to the server that needs to store the files
                $upload_html = ftp_put($check_config, $html_directory . basename($your_server_directory_html), $your_server_directory_html, FTP_BINARY);
                $upload_csv = ftp_put($check_config, $csv_directory . basename($your_server_directory_csv), $your_server_directory_csv, FTP_BINARY);
                $upload_email = ftp_put($check_config, $email_directory . basename($your_server_directory_email), $your_server_directory_email, FTP_BINARY);

                // Cấp quyền cho các tệp tin sau khi tải lên thành công
                $chmod_html = ftp_chmod($check_config, 0777, $html_directory . basename($your_server_directory_html));
                $chmod_csv = ftp_chmod($check_config, 0777, $csv_directory . basename($your_server_directory_csv));
                $chmod_email = ftp_chmod($check_config, 0777, $email_directory . basename($your_server_directory_email));


                unlink($your_server_directory_html);
                unlink($your_server_directory_csv);
                unlink($your_server_directory_email);
                if (!$upload_html && !$upload_csv && !$upload_email) {
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
            ftp_close($check_config);
        }
    }

    public function editAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        $this->data_ary['exam'] = $exam;

        $emails = $this->obj_model_exam_participant->getBy("exam_id", '=', $exam_id);
        $this->data_ary['emails'] = $emails;


        $req_method_ary = $request->getGet()->all();
        $req_method_ary['exam_id'] = $exam_id;
        $results_per_page = 5;
        $results_ary = $this->obj_model->getDetailExams($req_method_ary, $results_per_page);
        $this->data_ary['exam_details'] = $results_ary['results'];
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];


        //start add question
        // $req_method_ary = $request->getGet();
        // $exam_id = $req_method_ary->get('id');
        $results_ary = $this->obj_model_question_title->getAll("edit");
        $this->data_ary['question_titles'] = $results_ary;
        //end add question

        // echo "<pre>";
        // var_dump($results_ary);
        // die();


        $this->data_ary['content'] = "exam/edit";
    }

    public function update(Request $request)
    {

        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        //check has email
        $post_ary = $request->getPost()->all();
        $check_has_mail = $this->checkHasEmail($post_ary);

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
            $this->obj_model->beginTransaction();

            $this->obj_model->updateOne(
                [
                    'title' => $title,
                    'description' => $description,
                    'duration' => $duration
                ],
                "id = $id"
            );
            $this->obj_model_exam_participant->destroyBy("exam_id = " . $id);

            if ($check_has_mail) {
                $email_arrays = $post_ary['email'];
                $stt_email = 1;
                $arr_check_email = array();

                foreach ($email_arrays as $email) {
                    $email = trim($email);
                    if ($email == "") {
                        return $this->errorResponse("phải điền vào các ô email");
                    }
                    if (!email($email)) {
                        return $this->errorResponse("email số " . $stt_email . " không đúng định dạng");
                    }
                    if (in_array($email, $arr_check_email)) {
                        return $this->errorResponse("email số " . $stt_email . " đã trùng lặp");
                    }

                    $this->obj_model_exam_participant->create([
                        'exam_id' => $id,
                        'email' => $email,
                        'is_login' => 1,
                        'is_submit' => 2
                    ]);
                    array_push($arr_check_email, trim($email));

                    $stt_email++;
                }
            }
            $this->obj_model->commitTransaction();

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
        $question_id = $request->getGet()->get('question_id');
        $exam_id = $request->getGet()->get('exam_id');

        $this->obj_model_exam_question->destroyBy("question_id = $question_id and exam_id = $exam_id");
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
