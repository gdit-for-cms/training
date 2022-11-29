<?php

namespace App\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class QuestionController extends AppController
{
    use ResponseTrait;
    public array $data;

    public function listAction() {
        // $this->data['exams'] = Exam::all();
        $this->data['content'] = 'question/list';
    }

    public function newAction() {
        $this->data['content'] = 'exam/new';
    }

    public function create(Request $request) {
        // kiem tra lai transaction (rollback when something goes wrong)
        try {
            $type = $request->getPost()->get('type');
            $name = $request->getPost()->get('name');
            $opt1 = $request->getPost()->get('opt-1');
            $opt2 = $request->getPost()->get('opt-2');
            $opt3 = $request->getPost()->get('opt-3');
            $opt4 = $request->getPost()->get('opt-4');
            $answer = $request->getPost()->get('answer');
            $exam_id = $request->getGet()->get('id');

            // Insert into question table
            Question::create($name, $type, $answer);
            
            // Insert into question_detail table
            $question_id = Question::getId($name);
            Question::createDetail($question_id, $opt1, $opt2, $opt3, $opt4);

            // Insert into Exam_detail table
            Exam::createDetail([
                'exam_id' => $exam_id,
                'question_id' => $question_id,
            ]);
            
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function apiCheckName(Request $request) {
        $name = $request->getGet()->get('name');
        $check = Question::checkExist($name);
        
        return $this->successResponse((int)$check['mycheck']);
    }
}
