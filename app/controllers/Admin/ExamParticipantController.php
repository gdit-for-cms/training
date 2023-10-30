<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Controllers\Admin\AppController;
use App\models\ExamParticipant;
use App\models\Exam;
use Core\Http\ResponseTrait;
use Core\Http\Request;

class ExamParticipantController extends  AppController
{
    use ResponseTrait;

    public $title = "exam_participants";

    public array $data_ary;

    public object $obj_model;

    public object $obj_model_exam;

    public function __construct()
    {
        $this->obj_model = new ExamParticipant;
        $this->obj_model_exam = new Exam;
    }

    public function deleteAction(Request $request)
    {
        $participant_ids = $request->getGet()->get('id');
        if ($participant_ids == "select") {
            $ids = $request->getPost()->get('ids');
            foreach ($ids as $id) {
                $this->obj_model->destroyBy("id = $id");
            }
        } else {
            $this->obj_model->destroyBy("id = $participant_ids");
        }
    }

    public function sendMailAction(Request $request)
    {

        $req_method_ary = $request->getPost();
        $participant_id = $req_method_ary->get('participant_id');
        $exam_id = $req_method_ary->get('exam_id');
        $directory_domain = Config::FTP_DOMAIN;

        // thời lượng làm bài exam
        $exam = $this->obj_model_exam->getById($exam_id);
        $time_start = strtotime($exam['time_start']);
        $time_end = strtotime($exam['time_end']);
        // Tính toán thời gian chênh lệch (đơn vị giây)
        $time_difference = $time_end - $time_start;

        // Chuyển thời gian chênh lệch thành ngày, giờ, phút, và giây
        $days = floor($time_difference / (60 * 60 * 24));
        $hours = floor(($time_difference % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($time_difference % (60 * 60)) / 60);
        $seconds = $time_difference % 60;
        $time = "";
        if ($days > 0) {
            $time .= "$days ngày ";
        }
        if ($hours > 0) {
            $time .= "$hours giờ ";
        }
        if ($minutes > 0) {
            $time .= "$minutes phút ";
        }
        if ($seconds > 0) {
            $time .= "$seconds giây,";
        }

        $array_id = array();
        if ($participant_id == "select") {
            $ids = $req_method_ary->get('ids');
            foreach ($ids as $id) {
                array_push($array_id, $id);
            }
        } else {
            array_push($array_id, $participant_id);
        }

        //send mail
        // Send mail
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = Config::EMAIL_FROM;
        $success = true; // Biến để kiểm tra xem tất cả email đã được gửi thành công

        // Thiết lập ngôn ngữ cho hàm mb_send_mail() thành tiếng Việt
        mb_language('uni');

        // Tạo các header cho email
        $headers = "From: $from\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        foreach ($array_id as $id) {
            $participant = $this->obj_model->getBy("id", "=", $id)[0];

            $mes = "";
            $message = array();
            $mes .= "Link làm bài test: " . $directory_domain . $exam['id'] . "/" . $participant['random'] . "\n";
            $mes .= "Thời gian bắt đầu làm bài test: " . $exam['time_start'] . "\n";
            $mes .= "Thời gian làm bài trong: " . $time . "\n";

            $to = $participant['email'];
            $subject = $exam['title'];
            $message = $mes;

            // Chuyển tiếng Việt thành dạng ký tự Unicode (UTF-8)
            $subject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n");
            $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');

            if (mb_send_mail($to, $subject, $message, $headers)) {
                $this->obj_model->updateOne(
                    ['is_sendmail' => 1],
                    "id = $id"
                );
            } else {
                $success = false;
            }
        }

        if ($success) {
            return $this->successResponse("Tất cả email đã được gửi thành công.");
        } else {
            return $this->errorResponse("Có lỗi khi gửi một số email.");
        }
    }
}
