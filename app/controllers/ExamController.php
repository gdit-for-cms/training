<?php

namespace App\Controllers;

use App\Models\Exam;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ExamController extends AppController
{
    use ResponseTrait;
    public array $data;

    public function listAction()
    {
        $this->data['exams'] = Exam::all();
        $this->data['content'] = 'exam/list';
    }

    public function newAction()
    {
        $this->data['content'] = 'exam/new';
    }

    public function create(Request $request)
    {
        try {
            $name = $request->getPost()->get('name');
            $count_q = $request->getPost()->get('count_q');
            $topic_id = $request->getPost()->get('topic_id');
            $timelimit = $request->getPost()->get('timelimit');

            Exam::create([
                'name' => $name,
                'count_q' => $count_q,
                'topic_id' => $topic_id,
                'timelimit' => $timelimit,
            ]);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->getGet()->get('id');
            Exam::delete($id);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
