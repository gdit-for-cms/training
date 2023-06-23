<?php

namespace App\Controllers\Admin;

use App\models\Question;
use App\models\Step;
use App\models\AnswerDisable;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class PreviewController extends Controller
{
    use ResponseTrait;

    public $title = 'Preview';

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Question;
    }

    protected function before()
    {
        if (!checkAdmin()) {
            header('Location: /admin/auth/login');
            exit;
        }
        $this->data_ary['title'] = $this->title;
    }

    public function indexAction(Request $request)
    {
        $json = $request->getPost()->all();
        // var_dump($json["json"]);
        // die;

        $this->data_ary['render'] = $this->renderPreview(json_decode($json["json"], true));

        View::render('admin/table/preview.php', $this->data_ary);
    }

    private function renderPreview($jsons, $hidden = "")
    {
        $html = '';
        foreach ($jsons as $json) {
            $questionId = $json['question_id'];
            $questionContent = $json['question_content'];
            $questionRequired = $json['question_required'];
            $questionMultiAnswer = $json['question_multi_answer'];
            $questionContent = $json['question_content'];
            $answers = $json['answers'];
            $html .= '<div class="content_question my-5" ' . $hidden . '>';
            $html .= '<div class="wrapper_question p-3">';
            $html .= '<img src="/img/1.png" alt="" width="50px" height="50px">';
            $html .= '<h5 class="question">Question</h5>';
            $html .= '<h5 class="question_title p-3" data-question-id="' . $questionId . '" data-question-required="' . $questionRequired . '" data-multi-answer="' . $questionMultiAnswer . '">' . $questionContent . '</h5>';
            $html .= '</div>';


            $html .= '<div class="content_answer row">';

            if (!empty($answers)) {
                foreach ($answers as $answer) {

                    $answerId = $answer['answer_id'];
                    $answerContent = $answer['answer_content'];

                    $html .= '<div class="wrapper_answer col-4">';
                    $html .= '<div class="answer d-flex flex-row m-3 p-2">';
                    $htmlDisableAnswer = "";
                    if (!empty($answer['disable_answers'])) {
                        foreach ($answer['disable_answers'] as $disable_answer) {
                            $htmlDisableAnswer .= '' . $disable_answer . ', ';
                        }
                    }
                    $htmlStep = "";
                    if (!empty($answer['steps'])) {
                        foreach ($answer['steps'] as $step) {
                            $stepId = $step['step_id'];
                            $htmlStep .= '' . $stepId . ', ';
                        }
                    }
                    $htmlQuestionChild = "";
                    if (!empty($answer['questions'])) {
                        foreach ($answer['questions'] as $question) {
                            $htmlQuestionChild .= '' . $question['question_id'] . '';
                        }
                    }
                    $html .= '<input class="answer_checkbox ms-3" id="answer_' . $answerId . '" type="checkbox" data-answer-id="' . $answerId . '" data-disable-answer="' . $htmlDisableAnswer . '" data-step="' . $htmlStep . '" data-question-id-child="' . $htmlQuestionChild . '">';
                    $html .= '<label class="answer_content h5 p-3" for="answer_' . $answerId . '">';
                    $html .= $answerContent;
                    $html .= '</label>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
            }

            $html .= '</div>';
            $html .= '<hr>';
            $html .= '</div>';
            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    if (!empty($answer['questions'])) {
                        $html .= $this->renderPreview($answer['questions'], "hidden");
                    }
                }
            }
        }

        return $html;
    }

    public function previewAction()
    {
        View::render('admin/table/preview.php');
        // $json = $request->getPost()->all();
        // $this->data_ary['questions'] = $this->renderQuestion(json_decode($json["json"], true));
        // var_dump($this->data_ary['questions']);die;

    }
}
