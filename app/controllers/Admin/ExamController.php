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
use App\Models\User;

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

    public object $obj_model_user;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_modal_answer = new Answer;
        $this->app_request = new AppRequest;
        $this->obj_model_exam_participant = new ExamParticipant;
        $this->obj_model_question_title = new QuestionTitle;
        $this->obj_model_user = new User;
    }

    public function indexAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model->getExam($req_method_ary, $results_per_page);
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];
        $this->data_ary['exams'] = $results_ary['results'];
        $this->data_ary['content'] = 'exam/index';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
    }

    public function examDetailAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $exam =  $this->obj_model->getById($exam_id);
        $user = $this->obj_model_user->getById($exam['user_id']);

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
        $this->data_ary['user'] = $user;

        $file = '';
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $directory['html'] = $html_directory . $file;
        $directory['csv'] = $csv_directory . $file;
        $directory['domain'] = Config::FTP_DOMAIN  . $file;
        $this->data_ary['directory'] = $directory;

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

        $user_id = $result_vali_ary['user_id'];
        $title = trim($result_vali_ary['title']);
        $description = $result_vali_ary['description'];
        $date_start = $result_vali_ary['date_start'];
        $date_end = $result_vali_ary['date_end'];
        //so sanh datetime
        $check_time = false;
        if ((!empty($date_start) && empty($date_end)) || (empty($date_start) && !empty($date_end))) {
            return $this->errorResponse("Please fil out this field time");
        }
        if (!empty($date_start) && !empty($date_end)) {
            $current_time = time();
            if (strtotime($date_start) < $current_time) {
                return $this->errorResponse("Time start must be greater than or equal to the current time");
            }
            if (strtotime($date_start) >= strtotime($date_end)) {
                return $this->errorResponse("Time start must be less than the end time!");
            }
            $check_time = true;
        }
        $question_titles = $this->obj_model->getAll();
        foreach ($question_titles as $question_title) {
            $check_exam = strcasecmp($question_title['title'], $title);
            if ($check_exam == 0) {
                return $this->errorResponse('Exam collection has been exist');
            }
        }

        try {
            $this->obj_model->beginTransaction();
            $data = [
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
            ];

            if ($check_time) {
                $data['time_start'] = $date_start;
                $data['time_end'] = $date_end;
            }

            $this->obj_model->create($data);

            if ($check_has_mail) {
                $email_arrays = $req_method_ary['email'];
                $exam = $this->obj_model->getBy('title', '=', $title);
                $exam_id = $exam[0]['id'];
                $stt_email = 1;
                $arr_check_email = array();
                foreach ($email_arrays as $email) {
                    $email = trim($email);
                    if ($email == "") {
                        return $this->errorResponse("Email fields must be filled out");
                    }
                    if (!email($email)) {
                        return $this->errorResponse("
                        Email number " . $stt_email . " is not in the correct format");
                    }
                    if (in_array($email, $arr_check_email)) {
                        return $this->errorResponse("Email number " . $stt_email . " was duplicated");
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
            $answer_info = $this->obj_modal_answer->getBy('question_id', '=', $exam_question['question_id']);
            $question_answers[$question_id]['answers'] = $answer_info;
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

    public function deleteFTP($file)
    {
        if (ftp_delete($this->configFTP(), $file)) {
            echo "$file deleted successful\n";
        } else {
            echo "could not delete $file\n";
        }
        ftp_close($this->configFTP());
    }

    public function deleteFileFTPExam($exam_id)
    {
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $email_directory = Config::FTP_PUBLIC_DIRECTORY_EMAIL;

        $file_exam_html = $html_directory . $exam_id . ".html";
        $file_answer_csv = $csv_directory . $exam_id . ".csv";
        $file_email_csv = $email_directory . "email" . $exam_id . ".csv";

        $this->deleteFTP($file_exam_html);
        $this->deleteFTP($file_answer_csv);
        $this->deleteFTP($file_email_csv);
    }

    public function uploadAction(Request $request)
    {

        $html_content = $request->getPost()->get('html_content');
        $csv_content = $request->getPost()->get('csv_content');
        $csv_exam_participants = $request->getPost()->get('csv_exam_participants');
        $csv_link_exam_radom = $request->getPost()->get('csv_link_exam_radom');
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);
        if ($exam['time_start'] == null || $exam['time_end'] == null) {
            return $this->errorResponse("There is no start time and end time for the exam.");
        }
        $check_config = $this->configFTP();
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $your_server_directory = Config::YOUR_SERVER_DIRECTORY;
        $email_directory = Config::FTP_PUBLIC_DIRECTORY_EMAIL;
        $exam_random_derectory = Config::FTP_PUBLIC_DIRECTORY_LINK_EXAM;

        $file_name = $exam_id;
        $file_exam_participant = "email" . $exam_id;
        $file_link_random_exam = "rand" . $exam_id;

        $full_new_directory = $your_server_directory . $file_name;
        $full_new_directory_exam = $your_server_directory . $file_exam_participant;
        $full_new_directory_link_exam = $your_server_directory . $file_link_random_exam;

        $your_server_directory_html = $full_new_directory . '.html';
        $your_server_directory_csv = $full_new_directory . '.csv';
        $your_server_directory_email = $full_new_directory_exam . '.csv';
        $your_server_directory_link_exam = $full_new_directory_link_exam . '.csv';

        if ($check_config) {
            // upload files to my server
            $check_put_html = file_put_contents($your_server_directory_html, $html_content);
            $check_put_csv = file_put_contents($your_server_directory_csv, $csv_content);
            $check_put_csv_exam_participant = file_put_contents($your_server_directory_email, $csv_exam_participants);
            $check_put_csv_link_exam = file_put_contents($your_server_directory_link_exam, $csv_link_exam_radom);

            if ($check_put_html !== false && $check_put_csv !== false && $check_put_csv_exam_participant !== false) {
                //upload files html,answer,email,exam_random from your server to the server that needs to store the files
                $upload_html = ftp_put($check_config, $html_directory . basename($your_server_directory_html), $your_server_directory_html, FTP_BINARY);
                $upload_csv = ftp_put($check_config, $csv_directory . basename($your_server_directory_csv), $your_server_directory_csv, FTP_BINARY);
                $upload_email = ftp_put($check_config, $email_directory . basename($your_server_directory_email), $your_server_directory_email, FTP_BINARY);
                $upload_link_exam_random = ftp_put($check_config, $exam_random_derectory . basename($your_server_directory_link_exam), $your_server_directory_link_exam, FTP_BINARY);

                // Cấp quyền cho các tệp tin sau khi tải lên thành công
                $chmod_html = ftp_chmod($check_config, 0777, $html_directory . basename($your_server_directory_html));
                $chmod_csv = ftp_chmod($check_config, 0777, $csv_directory . basename($your_server_directory_csv));
                $chmod_email = ftp_chmod($check_config, 0777, $email_directory . basename($your_server_directory_email));
                $chmod_link_random = ftp_chmod($check_config, 0777, $exam_random_derectory . basename($your_server_directory_link_exam));

                unlink($your_server_directory_html);
                unlink($your_server_directory_csv);
                unlink($your_server_directory_email);
                unlink($your_server_directory_link_exam);
                if (!$upload_html && !$upload_csv && !$upload_email && !$upload_link_exam_random) {
                    die("Cann't upload");
                }
            } else {
                echo "failed.";
            }
            $this->obj_model->updateOne(
                [
                    'published' => 1,
                    'uploaded_at' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                "id = $exam_id"
            );
            return $this->successResponse();
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

        $results_ary = $this->obj_model_question_title->getAll("edit");
        $this->data_ary['question_titles'] = $results_ary;

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
        $date_start = $post_ary['date_start'];
        $date_end = $post_ary['date_end'];
        $check_time = false;
        if ((!empty($date_start) && empty($date_end)) || (empty($date_start) && !empty($date_end))) {
            return $this->errorResponse("Please fil out this field time");
        }
        if (!empty($date_start) && !empty($date_end)) {
            $current_time = time();
            if (strtotime($date_start) < $current_time) {
                return $this->errorResponse("Time start must be greater than or equal to the current time");
            }
            if (strtotime($date_start) >= strtotime($date_end)) {
                return $this->errorResponse("Time start must be less than the end time!");
            }
            $check_time = true;
        }
        if ($num_rows > 0 && $exam_check_ary[0]['id'] != $id) {
            return $this->errorResponse('Exam has been exist');
        }
        try {
            $this->obj_model->beginTransaction();
            $data = [
                'title' => $title,
                'description' => $description,
                'uploaded_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ];
            if ($check_time) {
                $data['time_start'] = $date_start;
                $data['time_end'] = $date_end;
            }
            $this->obj_model->updateOne(
                $data,
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

    public function unpublishAction(Request $request)
    {
        $exam_id = $request->getGet()->get('exam_id');
        $this->obj_model->updateOne(
            [
                'published' => 0,
                'updated_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ],
            "id = $exam_id"
        );
        $this->deleteFileFTPExam($exam_id);
        header('Location:/admin/exam/index');
        exit;
    }
    public function deleteAction(Request $request)
    {
        $exam_id = $request->getGet()->get('id');
        if ($exam_id == "select") {
            $ids = $request->getPost()->get('ids');
            foreach ($ids as $id) {
                $this->obj_model->destroyBy("id = $id");
            }
        } else {
            $this->obj_model->destroyBy("id = $exam_id");
        }
    }

    public function detailDeleteAction(Request $request)
    {
        $question_id = $request->getGet()->get('question_id');
        $exam_id = $request->getGet()->get('exam_id');
        $this->obj_model_exam_question->destroyBy("question_id = $question_id and exam_id = $exam_id");
    }

    public function editDetailExamAction(Request $request)
    {
        $post_ary = $request->getPost();
        $exam_id =  $post_ary->get('exam_id');
        $question_id =  $post_ary->get('question_id');
        $answer_ids =  $post_ary->get('selected_answer');
        $this->obj_model_exam_question->destroyBy('question_id' . '=' . $question_id . ' and ' . 'exam_id' . '=' . $exam_id);
        try {
            $this->obj_model->beginTransaction();

            foreach ($answer_ids as $answer_id) {
                $this->obj_model_exam_question->insert([
                    'exam_id' => $exam_id,
                    'answer_id' => $answer_id,
                    'question_id' => $question_id
                ]);
            }
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
            $this->obj_model->commitTransaction();

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
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
        $file = '';
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $directory['html'] = $html_directory . $file;
        $directory['csv'] = $csv_directory . $file;
        $directory['domain'] = Config::FTP_DOMAIN  . $file;
        $this->data_ary['directory'] = $directory;
        // pagination
        $req_method_ary = $request->getPost()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model->getExam($req_method_ary, $results_per_page);
        $results_ary['directory'] = $directory;
        return $this->responseShowRule(200, $results_ary);
    }
}
