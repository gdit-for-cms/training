<?php

namespace App\Controllers;

use App\Models\Exam;

class ExamController extends AppController
{
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
}
