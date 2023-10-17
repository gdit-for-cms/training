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

    public function whereMultiple(array $conditions)
    {
        $query = "";

        foreach ($conditions as $condition) {
            [$column, $operator, $value] = $condition;
            $value = addslashes($value);

            if (empty($query)) {
                $query = $this->where($column, $operator, $value);
            } else {
                $query = $this->andWhere($column, $operator, $value);
            }
        }

        return $query->get();
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

    public function getQuestionOther($req_method_ary, $results_per_page = 5)
    {
        if (!isset($req_method_ary['page']) || $req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $results = $this->join(" answer AS a", "question.id = a.question_id")
            ->orWhereNull(" question.question_title_id")
            ->groupBy("question.content")
            ->orderBy("question.id", "desc")
            ->limit($results_per_page, $page_first_result)
            ->get(
                "question.content AS question_content,
                     a.is_correct AS answer_correct,
                     question.id AS question_id,
                     GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content) SEPARATOR '|<@>|') AS answers
                "
            );
        $numbers_of_page = count($this->join(" answer AS a", "question.id = a.question_id")
            ->orWhereNull(" question.question_title_id")
            ->groupBy("question.content")->get("question.id"));
        return array(
            'numbers_of_page' => $numbers_of_page,
            'results' => $results,
            'page' => $req_method_ary['page']
        );
    }

    public function getQuestionAnswer($req_method_ary, $results_per_page = 5)
    {
        $exam_id = $req_method_ary['exam_id'];
        if ($req_method_ary['id'] == "other") {
            $this->orWhereNull("question.question_title_id");
        } else {
            $this->where("question.question_title_id", " = ", $req_method_ary['id']);
        }
        $results = $this->join(" answer AS a", "a.question_id = question.id")
            ->whereNotInSubquery("question.id, a.id", "exam_questions as eq", "eq.question_id, eq.answer_id", "eq.exam_id = $exam_id")
            ->groupBy("question.content")
            ->orderBy("question.question_title_id", "DESC")
            ->get("
                    question.id AS question_id,
                    question.content AS question_content,
                    a.is_correct AS answer_correct,
                    GROUP_CONCAT(CONCAT(a.is_correct, ' - ', a.content, ' - ', a.id) SEPARATOR '|<@>|') AS answers
                ");
        return $results;
    }

    function beginTransaction()
    {
        return $this->getDB()->beginTransaction();
    }

    function commitTransaction()
    {
        return $this->getDB()->commit();
    }
}
