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
class Question extends Model
{
    use QueryBuilder;

    private $_table = 'question';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function getAll()
    {
        return (new self)->latest()->get();
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

    public function getLatest()
    {
        return (new self)->last();
    }

    public static function  rules($change = '', $value = [])
    {
        $rules_ary = array(
            'title' => array(
                'required',
                'filled',
            ),
            'content' => array(
                'required',
                'filled',
            ),
        );

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
    public function destroyBy($condition)
    {
        return $this->destroy($condition);
    }

    public function getAllRelation($req_method_ary, $results_per_page = 10)
    {
        $db = static::getDB();
        // $query = 'SELECT q.id, q.title, q.content,a.content, a.is_correct, a.question_id
        // FROM question AS q
        // JOIN answer as a ON q.id = a.question_id' .
        //     ' ORDER BY q.id DESC';

        $query = 'SELECT
        question.id AS question_id,
        question.content AS question_content,
        GROUP_CONCAT(answer.content) AS answers
    FROM
        question
    LEFT JOIN
        answer ON question.id = answer.question_id
    GROUP BY
        question.id
    ORDER BY question.id DESC';
    //  LIMIT 0,5;';

        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        $stmt_count = $db->query($query);
        $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . " " . $limit_query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results);
        return $results_ary;
    }
}
