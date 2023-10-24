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

    public object $obj_model_answer;

    public object $app_request;

    public object $obj_model_exam_participant;

    public object $obj_model_question_title;

    public object $obj_model_user;

    public function __construct()
    {
        $this->obj_model = new Exam;
        $this->obj_model_question = new Question;
        $this->obj_model_exam_question = new ExamQuestion;
        $this->obj_model_answer = new Answer;
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
        //pagination
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = $results_ary['page'];
        $this->data_ary['exams'] = $results_ary['results'];

        $this->data_ary['content'] = 'exam/index';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'exam/new';
    }

    public function fetchCsvDataFromFtp($file_remote_derectory)
    {
        $ftp = $this->configFTP();

        // Đặt chế độ truyền dữ liệu sang chế độ ASCII (để đảm bảo đọc tệp CSV đúng cách)
        ftp_pasv($ftp, true);
        // kiểm tra file đã tồn tại hay chưa
        $fileList = ftp_nlist($ftp, dirname($file_remote_derectory));

        // Tệp tồn tại trên máy chủ FTP
        if (is_array($fileList) && in_array($file_remote_derectory, $fileList)) {

            // Tạo một tệp tạm thời để lưu dữ liệu CSV
            $local_csv_file = tempnam(sys_get_temp_dir(), 'csv_');

            // Lấy tệp email.csv từ máy chủ FTP và lưu vào tệp tạm thời
            $get = ftp_get($ftp, $local_csv_file, $file_remote_derectory, FTP_ASCII);
            if ($get !== false) {

                // Đọc dữ liệu từ tệp CSV tạm thời
                $email_data = file_get_contents($local_csv_file);

                // Xóa tệp CSV tạm thời
                unlink($local_csv_file);

                // close the connection and the file handler
                ftp_close($ftp);
            } else {
                return 'Error: Could not retrieve the file from the FTP server.';
            }
            return $email_data;
        } else {
            // The file does not exist on the FTP server
            return 'Error: Could not retrieve the file from the FTP server.';
        }
    }

    public function examDetailAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $exam_id = $req_method_ary['exam_id'];
        $exam =  $this->obj_model->getById($exam_id);
        $total_question_exam = count($this->obj_model_exam_question->getBy("exam_id", '=', $exam_id));
        $results_ary = $this->obj_model_exam_question->getExamQuestion($req_method_ary, $results_per_page = 5);
        $this->data_ary['exam_details'] = $results_ary['results'];
        $this->data_ary['exam'] = $exam;

        // path to remote file
        $email_directory = Config::FTP_PUBLIC_DIRECTORY_EMAIL;
        $remote_file_name = "email" . $exam_id . ".csv";
        $file_email_directoey = $email_directory . $remote_file_name;

        $result = $this->fetchCsvDataFromFtp($file_email_directoey);
        $data = array();
        if (strpos($result, 'Error') === 0) {
            // echo $result;
        } elseif (trim($result) != "") {
            $array_result = explode("\n", trim($result));
            foreach ($array_result as $participant) {
                $participant = explode(",", $participant);
                $data[] = array(
                    "email" => $participant['0'],
                    "random" => $participant['1'],
                    "is_login" => $participant['2'],
                    "is_submit" => $participant['3'],
                    "score" => $participant['4']
                );
            }
        }

        // Update participant status on form submission
        if (count($data) > 0) {
            $exam_participants = $this->obj_model_exam_participant->getBy("exam_id", "=", $exam_id);

            foreach ($exam_participants as $participant) {
                foreach ($data as $email_remote) {
                    if ($participant['email'] == $email_remote['email']) {

                        $this->obj_model_exam_participant->updateOne(
                            [
                                'is_login' => $email_remote['is_login'],
                                'is_submit' => $email_remote['is_submit'],
                                'score' => $email_remote['score']
                            ],
                            "id = $participant[id]"
                        );
                        break;
                    }
                }
            }
        }

        //pagination
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = $results_ary['page'];

        //get info User and Participants
        $this->data_ary['emails'] =  $this->obj_model_exam_participant->getBy("exam_id", '=', $exam_id);
        $this->data_ary['user'] = $this->obj_model_user->getById($exam['user_id']);
        $this->data_ary['total_question_exam'] = $total_question_exam;
        //get link do exam of Participants 
        $file = '';
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $directory['html'] = $html_directory . $file;
        $directory['csv'] = $csv_directory . $file;
        $directory['domain'] = Config::FTP_DOMAIN  . $file;
        $this->data_ary['directory'] = $directory;

        $this->data_ary['content'] = 'exam/detail';
    }

    //validate email
    public function checkEmail($emails)
    {
        $stt_email = 1;
        $arr_check_email = array();
        $errors = "";
        foreach ($emails as $email) {
            $email = trim($email);
            if ($email == "") {
                $errors = "Email field must be filled out";
                break;
            }
            if (!email($email)) {
                $errors = "Email number " . $stt_email . " is not in the correct format";
                break;
            }
            if (in_array($email, $arr_check_email)) {
                $errors = "Email number " . $stt_email . " was duplicated";
                break;
            }
            $stt_email++;
            array_push($arr_check_email, trim($email));
        }
        return $errors;
    }

    //validate start time and end time against the current time
    public function checkTimeExam($time_start, $time_end)
    {
        $errors = array();
        if ((!empty($time_start) && empty($time_end)) || (empty($time_start) && !empty($time_end))) {
            $errors[] = "Please fill out this field time";
        }
        if (!empty($time_start) && !empty($time_end)) {
            if (strtotime($time_start) < time()) {
                $errors[] = "Time start must be greater than or equal to the current time";
            }
            if (strtotime($time_start) >= strtotime($time_end)) {
                $errors[] = "Time start must be less than the end time!";
            }
        }
        if (empty($errors)) {
            return false;
        }
        return array_shift($errors);
    }

    // public function checkTimeExam($time_start, $time_end)
    // {
    //     $conditions = [
    //         // Kiểm tra điều kiện 1: Không được bỏ trống cả hai trường hoặc không điền cả hai trường
    //         'BothFieldsFilled' => !((empty($time_start) && empty($time_end)) || (!empty($time_start) && !empty($time_end))),

    //         // Kiểm tra điều kiện 2: Thời gian bắt đầu phải lớn hơn hoặc bằng thời gian hiện tại
    //         'StartTime' => empty($time_start) || strtotime($time_start) >= time(),

    //         // Kiểm tra điều kiện 3: Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc
    //         'StartTimeEndTime' => empty($time_start) || empty($time_end) || strtotime($time_start) < strtotime($time_end)
    //     ];

    //     foreach ($conditions as $errorKey => $condition) {
    //         if (!$condition) {
    //             return $this->errorResponse($this->getErrorMessage($errorKey));
    //         }
    //     }

    //     return null;
    // }

    // public function getErrorMessage($errorKey)
    // {
    //     $errorMessages = [
    //         'BothFieldsFilled' => "Please fill out both time fields",
    //         'StartTime' => "Time start must be greater than or equal to the current time",
    //         'StartTimeEndTime' => "Time start must be less than the end time"
    //     ];

    //     return $errorMessages[$errorKey] ?? "Unknown error";
    // }

    public function create(Request $request)
    {
        //validate
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";

            return $this->errorResponse($message_error);
        }
        $req_method_ary = $request->getPost()->all();
        // Check for valid email 
        if (isset($req_method_ary['email'])) {
            if ($this->checkEmail($req_method_ary['email'])) {
                return $this->errorResponse($this->checkEmail($req_method_ary['email']));
            }
        }
        // Check exam collection has been exist
        if (count($this->obj_model->getBy("title", "=", $result_vali_ary['title'])) > 0) {
            return $this->errorResponse("Exam collection has been exist");
        }

        //check for valid time_start and time_end
        if ($this->checkTimeExam($result_vali_ary['date_start'], $result_vali_ary['date_end'])) {
            return $this->errorResponse($this->checkTimeExam($result_vali_ary['date_start'], $result_vali_ary['date_end']));
        }

        $user_id = $result_vali_ary['user_id'];
        $title = trim($result_vali_ary['title']);
        $description = $result_vali_ary['description'];
        $time_start = $result_vali_ary['date_start'];
        $time_end = $result_vali_ary['date_end'];

        //data exam
        $data = [
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,

        ];
        if ($time_start && $time_end) {
            $data += ['time_start' => $time_start];
            $data += ['time_end' => $time_end];
        }

        try {
            // $this->obj_model->beginTransaction();
            $this->obj_model->create($data);

            if (isset($req_method_ary['email'])) {
                $exam = $this->obj_model->getBy('title', '=', $title);
                $exam_id = $exam[0]['id'];
                foreach ($req_method_ary['email'] as $email) {
                    //link random
                    $str_random = time() . $email;
                    $hash = hash('sha256', $str_random);
                    $randomChars = substr($hash, 0, 10);
                    //insert
                    $this->obj_model_exam_participant->create([
                        'exam_id' => $exam_id,
                        'email' => $email,
                        'random' => $randomChars,
                        'is_login' => 1,
                        'is_submit' => 2
                    ]);
                }
            }
            // $this->obj_model->commitTransaction();
            return $this->successResponse();
        } catch (\Throwable $th) {
            // $this->obj_model->rollBackTransaction();
            return $this->errorResponse($th->getMessage());
        };
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
            $answer_info = $this->obj_model_answer->getBy('question_id', '=', $exam_question['question_id']);
            $question_answers[$question_id]['answers'] = $answer_info;
        }
        $this->data_ary['question_answers'] = $question_answers;
        $this->data_ary['exam'] = $exam;
        $this->data_ary['exam_participants'] = $exam_participants;

        $this->data_ary['content'] = "exam/preview";
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

    public function deleteFileFTP($file)
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

        $this->deleteFileFTP($file_exam_html);
        $this->deleteFileFTP($file_answer_csv);
        $this->deleteFileFTP($file_email_csv);
    }

    public function uploadAction(Request $request)
    {
        // Get data from the request
        $req_method_ary = $request->getPost();
        $exam_content = $req_method_ary->get('exam_content');
        $answer = $req_method_ary->get('answer');
        $email = $req_method_ary->get('email');
        $exam_random = $req_method_ary->get('exam_random');
        $exam_id = $request->getGet()->get('id');
        $exam = $this->obj_model->getById($exam_id);

        // Check the exam's time
        if ($exam['time_start'] == null || $exam['time_end'] == null) {
            return $this->errorResponse("There is no start time and end time for the exam.");
        }
        $current_time = time();
        if (strtotime($exam['time_start']) < $current_time) {
            return $this->errorResponse("The exam time is not appropriate");
        }
        // Define paths and directories
        $your_server_directory = Config::YOUR_SERVER_DIRECTORY;
        $html_directory =  Config::FTP_PUBLIC_DIRECTORY_HTML;
        $csv_directory = Config::FTP_PUBLIC_DIRECTORY_CSV;
        $email_directory = Config::FTP_PUBLIC_DIRECTORY_EMAIL;
        $exam_random_derectory = Config::FTP_PUBLIC_DIRECTORY_LINK_EXAM;

        // Determine the full paths of the files
        $your_server_directory_html =  $your_server_directory . $exam_id . ".html";
        $your_server_directory_csv = $your_server_directory . $exam_id . ".csv";
        $your_server_directory_email = $your_server_directory . "email" . $exam_id . ".csv";
        $your_server_directory_link_exam = $your_server_directory . "ran" . $exam_id . ".csv";

        // Upload files to the FTP server
        $this->uploadFile($your_server_directory_html, $exam_content, $html_directory);
        $this->uploadFile($your_server_directory_csv, $answer, $csv_directory);
        $this->uploadFile($your_server_directory_email, $email, $email_directory);
        $this->uploadFile($your_server_directory_link_exam, $exam_random, $exam_random_derectory);

        // Update the exam's status
        $this->obj_model->updateOne(
            [
                'published' => 1,
                'uploaded_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ],
            "id = $exam_id"
        );
        return $this->successResponse();
    }

    public function uploadFile($your_server_directory, $file_content, $ftp_directory)
    {
        $check_config = $this->configFTP();

        if ($check_config) {

            // Write the file content to your server
            $check_put_file = file_put_contents($your_server_directory, $file_content);

            if ($check_put_file !== false) {
                // Upload the file from your server to the FTP server
                $upload_result = ftp_put($check_config, $ftp_directory . basename($your_server_directory), $your_server_directory, FTP_BINARY);

                // Set permissions for the file after uploading
                ftp_chmod($check_config, 0777, $ftp_directory . basename($your_server_directory));

                // Delete the file on your server
                unlink($your_server_directory);

                if ($upload_result) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
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
        $results_ary = $this->obj_model_exam_question->getExamQuestion($req_method_ary, $results_per_page);
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

        // Get data from the request
        $post_ary = $request->getPost()->all();
        $title = $post_ary['title'];
        $description = $post_ary['description'];
        $time_start = $post_ary['date_start'];
        $time_end = $post_ary['date_end'];
        $id = $post_ary['id'];
        $total_email_db = (int)$post_ary['total_email_db'];

        // Check for valid email 
        if (isset($post_ary['email'])) {
            if ($this->checkEmail($post_ary['email'])) {
                return $this->errorResponse($this->checkEmail($post_ary['email']));
            }
        }

        //check for valid time_start and time_end
        if ($this->checkTimeExam($time_start, $time_end)) {
            return $this->errorResponse($this->checkTimeExam($time_start, $time_end));
        }

        // Check exam collection has been exist
        $exam_check_ary = $this->obj_model->getBy('title', '=', $title);
        if (count($exam_check_ary) > 0 && $exam_check_ary[0]['id'] != $id) {
            return $this->errorResponse('Exam has been exist');
        }

        //data update exam
        $data = [
            'title' => $title,
            'description' => $description,
            'time_start' => $time_start,
            'time_end' => $time_end,
            'uploaded_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        //check email
        $email_delete_ids = array();
        $email_arrays = array();
        $check_delete_all_email = false;
        if (isset($post_ary['email'])) {
            $emails_db = $this->obj_model_exam_participant->getBy('exam_id', '=', $id, 'id,email');
            $email_arrays = $post_ary['email'];

            foreach ($emails_db as $key1 => $email_db) {
                $check = false;
                foreach ($email_arrays as $key2 => $email) {
                    if ($email_db['email'] == $email) {
                        unset($email_arrays[$key2]);
                        $check = true;
                        break;
                    }
                }
                if (!$check) {
                    $email_delete_ids[] = $emails_db[$key1]['id'];
                }
            }
        } else if ($total_email_db > 0) {
            $check_delete_all_email = true;
        }

        try {
            // $this->obj_model->beginTransaction();

            $this->obj_model->updateOne(
                $data,
                "id = $id"
            );
            foreach ($email_arrays as $email) {
                $str_random = time() . $email;
                $hash = hash('sha256', $str_random);
                $randomChars = substr($hash, 0, 10);
                $this->obj_model_exam_participant->create([
                    'exam_id' => $id,
                    'email' => $email,
                    'random' => $randomChars,
                    'is_login' => 1,
                    'is_submit' => 2
                ]);
            }

            if ($check_delete_all_email) {
                $this->obj_model_exam_participant->destroyBy("exam_id = $id");
            } elseif (count($email_delete_ids) > 0) {
                $email_delete_ids = implode(",", $email_delete_ids);
                $this->obj_model_exam_participant->destroyBy("id IN ($email_delete_ids)");
            }
            // $this->obj_model->commitTransaction();

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
                'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'time_start' => null,
                'time_end' => null
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
