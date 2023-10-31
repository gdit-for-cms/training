<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;
use Core\Http\Request;
use App\models\Question;
use App\models\Answer;
use App\Models\ExamQuestion;
use App\Models\QuestionTitle;
use App\Requests\AppRequest;
use Core\Http\ResponseTrait;

class QuestionController extends  AppController
{
    use ResponseTrait;

    public $title = "Question";

    public array $data_ary;

    public object $obj_model;

    public object $obj_model_answer;

    public object $app_request;

    public object $obj_model_question_title;

    public object $obj_model_exam_question;

    public function __construct()
    {
        $this->obj_model = new Question;
        $this->obj_model_answer = new Answer;
        $this->obj_model_question_title = new QuestionTitle;
        $this->app_request = new AppRequest;
        $this->obj_model_exam_question = new ExamQuestion;
    }

    public function indexAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model_question_title->getAllHasPagination($req_method_ary, $results_per_page);
        $this->data_ary['question_titles'] = $results_ary['results'];
        //pagiantionS
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];

        $this->data_ary['content'] = 'question/index';
    }

    public function newAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $question_title_id = $req_method_ary['ques-title'];
        $question_title = $this->obj_model_question_title->getById($question_title_id, 'id, title, description');
        $this->data_ary['question_title'] = $question_title;
        if (isset($req_method_ary['exam_id'])) {
            $this->data_ary['exam_id'] = $req_method_ary['exam_id'];
        }
        $this->data_ary['content'] = 'question/new';
    }

    // check answer
    public function check_answer($answers)
    {
        $errors = array();
        foreach ($answers as $answer) {
            if (strlen(trim($answer)) == 0) {
                $errors[] = 'You need to enter the answer.';
                break;
            }
            if (strlen($answer) > 2000) {
                $errors[] = "Answer length is limited to 2000 characters.";
                break;
            }
        }
        if (count($answers) > count(array_unique($answers))) {
            $errors[] = "Answers cannot be duplicated.";
        }
        if (count($answers) > 0) {
            return array_shift($errors);
        }
        return false;
    }

    public function create(Request $request)
    {
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        //Question data validation
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        //check answer
        if ($this->check_answer($result_vali_ary['answer'])) {
            return  $this->errorResponse($this->check_answer($result_vali_ary['answer']));
        }
        //check correct answer
        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("You need to choose at least one correct answer.");
        }
        //check has exam_id
        if (isset($result_vali_ary['exam_id'])) {
            $exam_id =  $result_vali_ary['exam_id'];
        }
        // check value question_title_id is null
        if (!isset($result_vali_ary['question_title_id'])) {
            $result_vali_ary['question_title_id'] = null;
        }
        // check unique question
        if (count($this->obj_model->getQuestion($result_vali_ary['question_title_id'], $result_vali_ary['content'])) > 0) {
            return $this->errorResponse("Question content already exits");
        }

        // get data request
        $content = $result_vali_ary['content'];
        $question_title_id =  $result_vali_ary['question_title_id'];
        $is_corrects = $result_vali_ary['is_correct'];
        $answers =  $result_vali_ary['answer'];

        $data = [
            'content' => htmlspecialchars($content),
        ];
        
        if (isset($question_title_id)) {
            $data += ['question_title_id' => $question_title_id];
        }

        try {
            // $this->obj_model->beginTransaction();
            $this->obj_model->create($data);
            $question = $this->obj_model->getLatest();
            if (isset($exam_id)) {
                $this->obj_model_exam_question->create(
                    [
                        'question_id' => $question['id'],
                        'exam_id' => $exam_id,
                    ]
                );
            }
            foreach ($answers as $index => $answerContent) {
                $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                $this->obj_model_answer->create(
                    [
                        'question_id' => $question['id'],
                        'content' => htmlspecialchars($answerContent),
                        'is_correct' => $isCorrect,
                    ]
                );
            }

            // $this->obj_model->commitTransaction();
            return $this->successResponse();
        } catch (\Throwable $th) {
            // $this->obj_model->rollBackTransaction();
            return $this->errorResponse($th->getMessage());
        };
    }

    public function editAction(Request $request)
    {
        $req_method_ary = $request->getGet();
        $id = $req_method_ary->get('question_id');
        $this->data_ary['question'] = $this->obj_model->getById($id, 'id, content, question_title_id');
        $this->data_ary['answers'] = $this->obj_model_answer->getBy('question_id', '=', $id);
        $this->data_ary['content'] = 'question/edit';
    }

    public function deleteAction(Request $request)
    {
        $question_id = $request->getGet()->get('id');
        if ($question_id == "select") {
            $ids = $request->getPost()->get('ids');
            foreach ($ids as $id) {
                $this->obj_model->destroyBy("id = $id");
            }
        } else {
            $this->obj_model->destroyBy("id = $question_id");
        }
    }

    public function update(Request $request)
    {
        $result_vali_ary = $this->app_request->validate($this->obj_model->rules(), $request, 'post');
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }
        //get data
        $answers =  $result_vali_ary['answer'];
        $question_id = $result_vali_ary['id'];
        $is_corrects = $result_vali_ary['is_correct'];
        $content = $result_vali_ary['content'];
        $question = $this->obj_model->getBy('id', '=', $question_id);
        
        //check answer
        if ($this->check_answer($result_vali_ary['answer'])) {
            return  $this->errorResponse($this->check_answer($result_vali_ary['answer']));
        }
        //check correct answer
        if (!isset($result_vali_ary['is_correct'])) {
            return $this->errorResponse("You need to choose at least one correct answer.");
        }
        // check unique question
        if (count($this->obj_model->getQuestion($question[0]['question_title_id'], $content)) > 0 && strcasecmp($content, $question[0]['content']) != 0) {
            return $this->errorResponse("Question content already exits");
        }

        try {
            // $this->obj_model->beginTransaction();
            $this->obj_model->updateOne(
                [
                    'content' => $content,
                ],
                "id = $question_id"
            );
            $this->obj_model_answer->destroyBy("question_id = $question_id");
            foreach ($answers as $index => $answerContent) {
                $isCorrect = in_array($index, $is_corrects) ? 1 : 0;
                $this->obj_model_answer->create(
                    [
                        'question_id' => $question_id,
                        'content' => $answerContent,
                        'is_correct' => $isCorrect,
                    ]
                );
            }
            // $this->obj_model->commitTransaction();
            return $this->successResponse();
        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage());
        };
    }

    public function detailAction(Request $request)
    {
        $req_method_ary = $request->getGet()->all();
        $results_per_page = 5;

        if ($req_method_ary['question_id'] == "other") {
            $results_ary = $this->obj_model->getQuestionOther($req_method_ary, $results_per_page);
        } else {
            $results_ary = $this->obj_model_question_title->getAllRelation($req_method_ary, $results_per_page);
            $question_title_id = $req_method_ary['question_id'];
            $this->data_ary['question_title'] = $this->obj_model_question_title->getById($question_title_id, "id,title,description");
        }

        $this->data_ary['question_titles'] = $results_ary['results'];
        $numbers_of_result = $results_ary['numbers_of_page'];
        $numbers_of_page = ceil($numbers_of_result / $results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;
        $this->data_ary['page'] = (float)$results_ary['page'];
        $this->data_ary['content'] = 'question/detail';
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
        $req_method_ary = $request->getPost()->all();
        $results_per_page = 10;
        $results_ary = $this->obj_model_question_title->getAllHasPagination($req_method_ary, $results_per_page);

        return $this->responseShowRule(200, $results_ary);
    }
}
