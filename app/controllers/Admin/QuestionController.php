<?php

namespace App\Controllers\Admin;


use App\Controllers\Admin\AppController;
use Core\Http\Request;
use App\models\Question;
use App\models\Answer;
use App\Requests\AppRequest;
use Core\Http\ResponseTrait;

class QuestionController extends  AppController
{
    use ResponseTrait;

    public $title = "Question";

    public array $data_ary;

    public object $obj_model;

    public object $obj_model_answer;

    public function __construct()
    {
        $this->obj_model = new Question;
        $this->obj_model_answer = new Answer;
    }

    public function indexAction(Request $request)
    {
        $this->data_ary['questions'] = $this->obj_model->getAll();
        $this->data_ary['answers'] = $this->obj_model_answer::getAll();
        $this->data_ary['content'] = 'question/index';
    }

    public function newAction()
    {
        $this->data_ary['content'] = 'question/new';
    }

    public function create(Request $request)
    {

        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $content = $result_vali_ary['content'];
        $title = $result_vali_ary['title'];
        $answers =  $result_vali_ary['answer'];


        foreach ($answers as $answer) {
            if (strlen(trim($answer)) == 0) {
                return $this->errorResponse("Bạn cần nhập vào câu trả lời.");
            }
        }
        $answer_comp = count(array_unique($answers));
        if (count($answers) > $answer_comp) {
            return $this->errorResponse("Các câu trả lời không được trùng lặp.");
        }

        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("Bạn cần chọn ít nhất một câu trả lời đúng");
        }

        $is_corrects = $result_vali_ary['is_correct'];
        $question_check_ary = $this->obj_model->getBy('content', '=', $content);
        $num_rows = count($question_check_ary);
        // return $this->errorResponse($is_corrects);
        if ($num_rows == 1) {
            return $this->errorResponse('Question has been exist');
        } else {
            // Bắt đầu transaction
            // $this->obj_model::beginTransaction();

            try {
                $questionId = $this->obj_model->create(
                    [
                        'title' => $title,
                        'content' => $content,
                    ]
                );

                $questionId = $this->obj_model->getLatest();

                // Insert các answer dựa vào questionId và vị trí đúng
                foreach ($answers as $index => $answerContent) {
                    $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                    $this->obj_model_answer->create(
                        [
                            'question_id' => $questionId['id'],
                            'content' => $answerContent,
                            'is_correct' => $isCorrect,
                        ]
                    );
                }
                // Commit transaction
                // $this->obj_model::commit();

                return $this->successResponse();
            } catch (\Throwable $th) {
                // Rollback transaction nếu có lỗi
                // $this->obj_model::rollback();
                return $this->errorResponse($th->getMessage());
            };
        }
    }
    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        $this->data_ary['question'] = $this->obj_model->getById($id, 'id, title, content');
        $this->data_ary['answers'] = $this->obj_model_answer->getBy('question_id', '=', $id);

        $this->data_ary['content'] = 'question/edit';
    }

    public function update(Request $request)
    {

        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $content = $result_vali_ary['content'];
        $title = $result_vali_ary['title'];
        $answers =  $result_vali_ary['answer'];


        foreach ($answers as $answer) {
            if (strlen(trim($answer)) == 0) {
                return $this->errorResponse("Bạn cần nhập vào câu trả lời.");
            }
        }
        $answer_comp = count(array_unique($answers));
        if (count($answers) > $answer_comp) {
            return $this->errorResponse("Các câu trả lời không được trùng lặp.");
        }

        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("Bạn cần chọn ít nhất một câu trả lời đúng");
        }

        $is_corrects = $result_vali_ary['is_correct'];
        $question_check_ary = $this->obj_model->getBy('content', '=', $content);
        $num_rows = count($question_check_ary);

        if ($num_rows == 1) {
            return $this->errorResponse('Question has been exist');
        } else {
            // Bắt đầu transaction
            // $this->obj_model::beginTransaction();

            try {
                $questionId = $this->obj_model->create(
                    [
                        'title' => $title,
                        'content' => $content,
                    ]
                );

                $questionId = $this->obj_model->getLatest();

                // Insert các answer dựa vào questionId và vị trí đúng
                foreach ($answers as $index => $answerContent) {
                    $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                    $this->obj_model_answer->create(
                        [
                            'question_id' => $questionId['id'],
                            'content' => $answerContent,
                            'is_correct' => $isCorrect,
                        ]
                    );
                }
                // Commit transaction
                // $this->obj_model::commit();

                return $this->successResponse();
            } catch (\Throwable $th) {
                // Rollback transaction nếu có lỗi
                // $this->obj_model::rollback();
                return $this->errorResponse($th->getMessage());
            };
        }
    }
}
