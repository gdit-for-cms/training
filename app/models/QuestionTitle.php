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
class QuestionTitle extends Model
{
    use QueryBuilder;

    private $_table = 'question_title';

    /**
     * Get all the questions as an associative array
     *
     * @return array
     */

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public static function  rules($change = '', $value = [])
    {
        $rules_ary = array(
            'title' => array(
                'required',
                'filled',
                'maxLen:255'
            ),
            'description' => array(),
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

    public function getAllRelation($req_method_ary, $results_per_page = 5)
    {
        // $db = static::getDB();
        // $query = "SELECT
        // qt.id AS question_title_id,
        // qt.title AS question_title_title,
        // qt.description AS question_title_description,
        // q.content AS question_content,
        // a.is_correct AS answer_correct,
        // q.id AS question_id,
        // -- GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content)) AS answers
        // GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content) SEPARATOR '|<@>|') AS answers
        // FROM
        //     question_title AS qt
        // LEFT JOIN
        //     question AS q ON qt.id = q.question_title_id
        // LEFT JOIN
        //     answer AS a ON q.id = a.question_id
        // WHERE 
        //     qt.id = $req_method_ary[question_id]
        // GROUP BY
        //     qt.id, qt.title, qt.description, q.content
        // ORDER BY
        //     question_title_id DESC";

        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }
        if ($req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }
        // $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        // $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;
        // $stmt_count = $db->query($query);
        // $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        // $stmt = $db->query($query . " " . $limit_query);
        // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = $this->join(" question AS q", "question_title.id = q.question_title_id")
            ->join(" answer AS a", "q.id = a.question_id")
            ->where("question_title.id", "=", $req_method_ary['question_id'])
            ->groupBy("question_title.id")
            ->orderBy("question_title_id", "desc")
            ->get("
            question_title.id AS question_title_id, 
            question_title.title AS question_title_title,
            question_title.description AS question_title_description,
            q.content AS question_content,
            a.is_correct AS answer_correct,
            q.id AS question_id,
            GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content) SEPARATOR '|<@>|') AS answers
            ");

        $numbers_of_page = count($results);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results, 'page' => $req_method_ary['page']);
        return $results_ary;
    }

    public function getAllHasPagination($req_method_ary, $results_per_page = 5)
    {
        $where = '';
        $keyword_search = "";
        if (isset($req_method_ary['keyword'])) {
            $where = trim($req_method_ary['keyword']);
            $keywords = str_split($where);
            $specialChars = ["@", "#", "$", "%", "^", "&", "(", ")", "_", "+", "|", "~", "=", "`", "{", "}", "[", "]", ":", "\\", ";", "'", "<", ">", "?", ",", ".", "/", "\\", "-"];
            $a = 1;
            foreach ($keywords as $keyword) {
                if (in_array($keyword, $specialChars)) {
                    if ($keyword == "\\") {
                        $keyword_search .= "\\\\" . $keyword;
                    } else {
                        $keyword_search .= "\\" . $keyword;
                    }
                    $a++;
                } else {
                    $keyword_search .= $keyword;
                }
            }
        }
        $db = static::getDB();
        $query = 'SELECT
        question_title.id AS question_id,
        question_title.title AS question_title,
        question_title.description AS question_description,
        question_title.updated_at AS question_updated_at
        FROM
        question_title where question_title.title like ' . ' "%' . $keyword_search . '%" ESCAPE "\\\\"
        ORDER BY question_title.id DESC';
        if (!isset($req_method_ary['page']) || $req_method_ary['page'] < 1) {
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

    public function destroyBy($condition)
    {
        return $this->destroy($condition);
    }

    public function getById($id, $column = '*')
    {
        return $this->find($id, $column);
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }
}
