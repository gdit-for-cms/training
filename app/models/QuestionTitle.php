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
        if (!isset($req_method_ary['page']) || $req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $results = $this->join(" question AS q", "question_title.id = q.question_title_id")
            ->join(" answer AS a", "q.id = a.question_id")
            ->where("question_title.id", "=", $req_method_ary['question_id'])
            ->groupBy("question_title.id, question_title.title, question_title.description, q.content")
            ->orderBy("q.question_title_id", "desc")
            ->limit($results_per_page, $page_first_result)
            ->get("
                question_title.id AS question_title_id, 
                question_title.title AS question_title_title,
                question_title.description AS question_title_description,
                q.content AS question_content,
                a.is_correct AS answer_correct,
                q.id AS question_id,
                GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content) SEPARATOR '|<@>|') AS answers
            ");
        $numbers_of_page = count($this->join(" question AS q", "question_title.id = q.question_title_id")
            ->where("question_title.id", "=", $req_method_ary['question_id'])
            ->get("
                question_title.id AS question_title_id, 
                q.content AS question_content,
                q.id AS question_id
            "));

        return array(
            'numbers_of_page' => $numbers_of_page,
            'results' => $results,
            'page' => $req_method_ary['page']
        );
    }

    public function getAllHasPagination($req_method_ary, $results_per_page = 5)
    {
        $key_word = '';
        //filter 
        if (isset($req_method_ary['keyword'])) {
            $key_word = trim($req_method_ary['keyword']);
            $this->whereLikeWithSpecialCharEscape("question_title.title", $key_word);
        }

        if (!isset($req_method_ary['page']) || $req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $results = $this->orderBy("question_title.id", " DESC")
            ->limit($results_per_page, $page_first_result)
            ->get("question_title.id AS question_id,
            question_title.title AS question_title,
            question_title.description AS question_description,
            question_title.updated_at AS question_updated_at");
        $numbers_of_page = count($this->getAll());

        return array(
            'numbers_of_page' => $numbers_of_page,
            'results' => $results,
            'page' => $req_method_ary['page']
        );
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
