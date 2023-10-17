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

    public function getExamQuestion($req_method_ary, $results_per_page = 5)
    {
        $exam_id = $req_method_ary['exam_id'];
        if (!isset($req_method_ary['page']) || $req_method_ary['page'] < 1) {
            $req_method_ary['page'] = '1';
        }
        $numbers_of_page =  count($this->getBy("exam_id", "=", $exam_id, "id"));

        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $results = $this->join(" question", "$this->_table.question_id = question.id")
            ->join(" answer as a", "question.id = a.question_id")
            ->where("$this->_table.exam_id", " = ", "$exam_id")
            ->groupBy("question.id")
            ->orderBy("question.id")
            ->limit($results_per_page, $page_first_result)
            ->get("question.id AS question_id, question.content AS question_content, GROUP_CONCAT(CONCAT(a.content, ' - ', a.is_correct) SEPARATOR '|<@>|') AS answers");

        return array(
            'numbers_of_page' => $numbers_of_page,
            'results' => $results,
            'page' => $req_method_ary['page']
        );
    }
}
