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

    public function getDetailExams($req_method_ary, $results_per_page = 5)
    {
        $exam_id = $req_method_ary['exam_id'];
        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $results = $this->join(" question as q", $this->_table . ".question_id = q.id")
            ->join(" answer as a", "q.id = a.question_id")
            ->join(" question_title as qt", "qt.id = q.question_title_id")
            ->where("exam_questions.exam_id", " = ", "$exam_id")
            ->groupBy("q.id")
            ->orderBy("q.id")
            ->limit($results_per_page, $page_first_result)
            ->get("qt.id AS question_title_id, qt.title AS question_title_tile, qt.description AS question_title_description,
                   q.id AS question_id, q.content AS question_content, GROUP_CONCAT(CONCAT(a.content, ' - ', a.is_correct) SEPARATOR '|<@>|') AS answers");

        $numbers_of_page = count($results);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results, 'page' => $req_method_ary['page']);

        return $results_ary;
    }
}
