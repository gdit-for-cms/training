<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class ExamParticipant extends Model
{
    use QueryBuilder;

    private $_table = 'exam_participants';

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function getById($id)
    {
        return $this->where('id', "=", $id)->get('*')[0];
    }

    public function destroyBy($condition)
    {
        return $this->destroy($condition);
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function create($data)
    {
        return $this->insert($data);
    }
}
