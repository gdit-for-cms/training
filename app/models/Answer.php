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
class Answer extends Model
{
    use QueryBuilder;

    private $_table = 'answer';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function getByIdQuestion($id)
    {
        $db = static::getDB();
        $query = 'SELECT * FROM answer WHERE question_id = ' . $id . ' ORDER BY id DESC';
        $stmt = $db->query($query);
        $results_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results_ary;
    }
    

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function getById($id, $column = '*')
    {
        return $this->find($id, $column);
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }

    public function destroyOne($condition)
    {
        return $this->destroy($condition);
    }

    public static function rules($change = '', $value = [])
    {
        $rules_ary = [
            'question_id' => [
                'required',
            ],
            'content' => [
                'required',
                'filled',
                'content',
            ],
            'is_correct' => [
                'required',
            ],
        ];

        switch ($change) {
            case 'add':
                return array_merge($rules_ary, $value);
                break;
            case 'remove':
                foreach ($value as $each) {
                    if (array_key_exists($each, $rules_ary)) {
                        unset($rules_ary[$each]);
                    }
                }
                return $rules_ary;
                break;
            case 'replace':
                return $value;
                break;
            default:
                return $rules_ary;
                break;
        }
    }
}
