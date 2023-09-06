<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use PDO;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

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
}
