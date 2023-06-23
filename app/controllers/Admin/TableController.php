<?php

namespace App\Controllers\Admin;

use App\models\Question;
use App\models\Step;
use App\models\AnswerDisable;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class TableController extends AppController
{
    use ResponseTrait;

    public $title = 'Create Table';

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Question;
    }

    public function indexAction()
    {
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = 'table/index';
        $this->data_ary['questions'] = $this->renderQuestion(json_decode($this->obj_model->getResultJson(), true));
        $this->data_ary['steps'] = Step::getAll();
    }

    private function renderQuestion($jsons, $margin = 0)
    {
        $html = '';
        foreach ($jsons as $json) {
            $question_id = $json['question_id'];
            $question_content = $json['question_content'];
            $question_required = $json['question_required'];
            $question_multi = $json['question_multi_answer'];
            $answers = $json['answers'];
            $html .= '<div class="wrapper_question ms-' . $margin . '">';
            $html .= '<div class="question bg-question p-3 d-flex justify-content-between align-items-center">';
            $html .= '<div data-question-id="' . $question_id . '" data-question-required="' . $question_required . '" data-multi-answer="' . $question_multi . '" class="question_content">' . $question_content . '</div>';
            $html .= '<div>';
            $html .= '<button data-question-id="' . $question_id . '" type="button" class="mx-1 btn btn-primary button_question_edit">Edit</button>';
            $html .= '<button data-question-id="' . $question_id . '" type="button" class="mx-1 btn btn-success button_question_create_answer">Create answer</button>';
            $html .= '<button data-question-id="' . $question_id . '" type="button" class="mx-1 btn btn-danger button_question_delete">Delete</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="content_answer">';
            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    $answer_id = $answer['answer_id'];
                    $answer_content = $answer['answer_content'];
                    $html .= '<div class="wrapper_answer ms-5">';
                    $html .= '<div class="answer bg-info p-3 d-flex justify-content-between align-items-center">';
                    $html .= '<div data-answer-id="' . $answer_id . '" class="answer_content">' . $answer_content . '</div>';
                    $html .= '<div>';
                    $html .= '<button data-answer-id="' . $answer_id . '" type="button" class="mx-1 btn btn-warning button_answer_disable">Disable</button>';
                    $html .= '<button data-answer-id="' . $answer_id . '" type="button" class="mx-1 btn btn-primary button_answer_edit">Edit</button>';
                    $html .= '<button data-answer-id="' . $answer_id . '" type="button" class="mx-1 btn btn-success button_answer_create_question">Create question</button>';
                    $html .= '<button data-answer-id="' . $answer_id . '" type="button" class="mx-1 btn btn-success button_answer_create_step">Create steps</button>';
                    $html .= '<button data-answer-id="' . $answer_id . '" type="button" class="mx-1 btn btn-danger button_answer_delete">Delete</button>';
                    $html .= '</div>';
                    $html .= '</div>';
                    if (!empty($answer['steps'])) {
                        $steps = $answer['steps'];
                        $html .= '<div class="content_step ms-5">';
                        foreach ($steps as $step) {
                            $step_id = $step['step_id'];
                            $step_name = $step['step_name'];
                            $html .= '<div data-step-id="' . $step_id . '" class="step bg-step p-3 d-flex justify-content-between align-items-center">';
                            $html .= '<div class="step_id">' . $step_id . '</div>';
                            $html .= '<div class="step_name">' . $step_name . '</div>';
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                    } 
                    if (!empty($answer['disable_answers'])) {
                        $disable_answers = $answer['disable_answers'];
                        $html_disable_answer = "";
                        foreach ($disable_answers as $disable_answer) {
                            $html_disable_answer .= '' . $disable_answer["disable_answers_id"] . ', ';
                        }
                        $html .= '<div class="disable_answer" hidden>';
                        $html .= $html_disable_answer;
                        $html .= '</div>';
                    }
                    if (!empty($answer['questions'])) {
                        $html .= '<div class="content_question">';
                        $html .= $this->renderQuestion($answer['questions'], 5);
                        $html .= '</div>';
                    }

                    $html .= '</div>';
                }
            }

            $html .= '</div>';

            $html .= '</div>';
        }

        return $html;
    }
}
