<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class ExamQuestion extends Model
{
    use QueryBuilder;

    private $_table = 'exam_questions';

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function getBy($column, $operator, $value, $select_column = '*')
    {
        return $this->where($column, $operator, $value)->get($select_column);
    }

    public function destroyBy($condition)
    {
        return $this->destroy($condition);
    }

    public function getExamQuestionByIds($examId, $questionIds, $selectColumn = '*')
    {
        return $this->where('exam_id', '=', $examId)
            ->where('question_id', '=', $questionIds)
            ->get($selectColumn);
    }

    public function create($data)
    {
        return $this->insert($data);
    }
}
