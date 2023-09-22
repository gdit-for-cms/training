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
class Exam extends Model
{
    use QueryBuilder;

    private $_table = 'exam';

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

    public function getAllRelation($req_method_ary, $results_per_page = 1)
    {
        $db = static::getDB();

        $query = 'SELECT 
        e.id AS exam_id, 
        e.title AS exam_title, 
        e.description AS exam_description,
        e.published AS exam_published,
        q.id AS question_id, 
        q.content AS question_content, 
        q.title as question_title,
        GROUP_CONCAT(CONCAT(q.title, " - ", q.content)) AS questions
      FROM exam AS e
      LEFT JOIN exam_questions AS qe ON e.id = qe.exam_id
      LEFT JOIN question AS q ON qe.question_id = q.id
GROUP BY
e.id
ORDER BY e.id DESC';

        if (!isset($req_method_ary['page'])) {
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

    public function getDetailExams($req_method_ary, $results_per_page = 5)
    {
        $exam_id = $req_method_ary['exam_id'];

        if (isset($req_method_ary['exam_id'])) {
            $exam_id = $req_method_ary['exam_id'];
        }

        $db = static::getDB();
        $query = "SELECT
        qt.id AS question_title_id,
        qt.title AS question_title_tile,
        qt.description AS question_title_description,
        q.id AS question_id,
        q.content AS question_content,
        GROUP_CONCAT(CONCAT(a.content, ' - ', a.is_correct)) AS answers
        FROM
            exam_questions as eq
        LEFT JOIN
            answer AS a ON eq.answer_id = a.id
        LEFT JOIN
            question as q ON eq.question_id = q.id
        LEFT JOIN
            question_title as qt ON q.question_title_id = qt.id
        WHERE 
            eq.exam_id = $exam_id 
        GROUP BY
            q.id
        ORDER BY q.id DESC";

        if (!isset($req_method_ary['page'])) {
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

    public function getExam($req_method_ary, $results_per_page = 5)
    {


        $db = static::getDB();
        $query = "SELECT e.id, e.title, e.description, e.published, e.duration, e.updated_at FROM exam as e ORDER BY e.id DESC";

        $req_method_ary['page'] = isset($req_method_ary['page']) && $req_method_ary['page'] >= 1 ? $req_method_ary['page'] : '1';

        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        $stmt_count = $db->query($query);
        $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . " " . $limit_query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results, 'page' => $req_method_ary['page']);


        return $results_ary;
    }

    public function getExamsWithQuestions($id = '')
    {
        $db = static::getDB();

        // Thực hiện câu truy vấn để lấy thông tin bài thi và câu hỏi liên quan
        $query = "SELECT e.id AS exam_id, e.title AS exam_title, e.description AS exam_description,
        e.published AS exam_published,q.id AS question_id, q.content AS question_content, q.title as question_title
                  FROM exam AS e
                  LEFT JOIN exam_questions AS qe ON e.id = qe.exam_id
                  LEFT JOIN question AS q ON qe.question_id = q.id";

        $stmt = $db->query($query);
        $results_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results_ary;
    }
    public function rules($change = '', $value = array())
    {
        $rules_ary = array(
            'title' => array(
                'required',
                'name',
                'filled',
            ),
            'duration' => array(
                'required',
                'filled',

            ),
            'description' => array(),
        );
        switch ($change) {
            case 'add':
                return array_merge($rules_ary, $value);
                break;
            case 'remove_key':
                foreach ($value as $each) {
                    if (array_key_exists($each, $rules_ary)) {
                        unset($rules_ary[$each]);
                    }
                }
                return $rules_ary;
                break;
            case 'remove_value':
                foreach ($value as $key => $value_key) {
                    if (array_key_exists($key, $rules_ary)) {
                        foreach ($value_key as $each) {
                            $key_value = array_search($each, $rules_ary[$key]);
                            unset($rules_ary[$key][$key_value]);
                        }
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

    public function create($data)
    {
        return $this->insert($data);
    }

    function beginTransaction(){
        return $this->getDB()->beginTransaction();
    }

    function commitTransaction(){
        return $this->getDB()->commit();
    }
}
