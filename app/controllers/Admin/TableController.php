<?php

namespace App\Controllers\Admin;

use App\models\Question;
use App\models\Step;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class TableController extends Controller
{
    use ResponseTrait;

    public $title = 'Create Table';

    public array $data_ary;

    public object $obj_model;

    public function __construct()
    {
        $this->obj_model = new Question;
    }

    public function indexAction(Request $request)
    {
        // $get_ary = $request->getGet()->all();
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = 'table/index';
        $this->data_ary['questions'] = $this->renderQuestion(json_decode($this->obj_model->getResultJson(), true));
        // $this->data_ary['steps'] = Step::getAll();
        View::render('admin/table/index.php', $this->data_ary);
    }

    private function renderQuestion($jsons, $margin = 0)
    {
        $html = '';
        foreach ($jsons as $json) {
            $questionId = $json['question_id'];
            $questionContent = $json['question_content'];
            $answers = $json['answers'];

            $html .= '<div class="wrapper_question ms-' . $margin . '">';
            $html .= '<div class="question bg-question p-3 d-flex justify-content-between align-items-center">';
            $html .= '<div data-question-id="' . $questionId . '" class="question_content">' . $questionContent . '</div>';
            $html .= '<div>';
            $html .= '<button data-question-id="' . $questionId . '" type="button" class="mx-1 btn btn-primary button_question_edit">Edit</button>';
            $html .= '<button data-question-id="' . $questionId . '" type="button" class="mx-1 btn btn-success button_question_create_answer">Create selection</button>';
            $html .= '<button data-question-id="' . $questionId . '" type="button" class="mx-1 btn btn-danger button_question_delete">Delete</button>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div class="content_answer">';

            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    $answerId = $answer['answer_id'];
                    $answerContent = $answer['answer_content'];

                    $html .= '<div class="wrapper_answer ms-5">';
                    $html .= '<div class="answer bg-info p-3 d-flex justify-content-between align-items-center">';
                    $html .= '<div data-answer-id="' . $answerId . '" class="answer_content">' . $answerContent . '</div>';
                    $html .= '<div>';
                    $html .= '<button data-answer-id="' . $answerId . '" type="button" class="mx-1 btn btn-warning button_answer_dialog">Dialog</button>';
                    $html .= '<button data-answer-id="' . $answerId . '" type="button" class="mx-1 btn btn-primary button_answer_edit">Edit</button>';
                    $html .= '<button data-answer-id="' . $answerId . '" type="button" class="mx-1 btn btn-success button_answer_create_question">Create question</button>';
                    $html .= '<button data-answer-id="' . $answerId . '" type="button" class="mx-1 btn btn-success button_answer_create_step">Create steps</button>';
                    $html .= '<button data-answer-id="' . $answerId . '" type="button" class="mx-1 btn btn-danger button_answer_delete">Delete</button>';
                    $html .= '</div>';
                    $html .= '</div>';


                    if (!empty($answer['steps'])) {
                        $html .= '<div class="content_step ms-5">';
                        foreach ($answer['steps'] as $step) {
                            $stepId = $step['step_id'];
                            $stepName = $step['step_name'];

                            $html .= '<div data-step-id="' . $stepId . '" class="step bg-step p-3 d-flex justify-content-between align-items-center">';
                            $html .= $stepId;
                            $html .= '<hr>';
                            $html .= $stepName;
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                    } elseif (!empty($answer['questions'])) {
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
