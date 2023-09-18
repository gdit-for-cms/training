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
     * Get all the questions as an associative array
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

    public function getAllRelation($req_method_ary, $results_per_page = 5)
    {
        // echo "<pre>";
        // var_dump($req_method_ary);
        // die();

        $db = static::getDB();
        $query = "SELECT
        qt.id AS question_title_id,
        qt.title AS question_title_title,
        qt.description AS question_title_description,
        q.content AS question_content,
        a.is_correct AS answer_correct,
        q.id AS question_id,
        GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content)) AS answers
    FROM
        question_title AS qt
    LEFT JOIN
        question AS q ON qt.id = q.question_title_id
    LEFT JOIN
        answer AS a ON q.id = a.question_id
    WHERE qt.id = $req_method_ary[question_id]
    GROUP BY
        qt.id, qt.title, qt.description, q.content
    ORDER BY
        question_title_id DESC";


        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }
        if ($req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }


        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        $stmt_count = $db->query($query);
        $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . " " . $limit_query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results, 'page' => $req_method_ary['page']);
        return $results_ary;
    }

    public function getQuestionAnswer($req_method_ary, $results_per_page = 5)
    {
        // echo "<pre>";
        // var_dump($req_method_ary);
        // die();

        $db = static::getDB();
        $query = "SELECT
        
        q.id AS question_id,
        q.content AS question_content,
        a.is_correct AS answer_correct,
        GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content)) AS answers
    FROM
        question AS q
    LEFT JOIN
        answer AS a ON q.id = a.question_id
    WHERE q.question_title_id = $req_method_ary[id]
    GROUP BY
        q.content
    ORDER BY
        question_title_id DESC";


        // if (!isset($req_method_ary['page'])) {
        //     $req_method_ary['page'] = '1';
        // }
        // if ($req_method_ary['page'] < 1) {
        //     $req_method_ary['page'] = '1';
        // }


        // $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        // $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        // $stmt_count = $db->query($query);
        // $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results, 'page' => $req_method_ary['page']);
        // $results_ary = array('results' => $results);
        return $results;
    }
}
