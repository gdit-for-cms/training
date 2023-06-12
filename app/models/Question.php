<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Question extends Model
{
    use QueryBuilder;

    private $_table = 'tbl_question';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public function getAll()
    {
        return $this->all();
    }

    public function getQuestionDad()
    {
        $db = static::getDB();
        $query = 'SELECT tbl_question.id question_id, 
        tbl_question.content question_content, 
        tbl_question.parent_answer_id question_parent_answer_id, 
        tbl_question.category_id question_category_id, 
        tbl_answer.id answer_id, 
        tbl_answer.content answer_content, 
        tbl_answer.question_id answer_question_id, 
        tbl_step_master.step_id, 
        tbl_step_master.step_name
        FROM tbl_question
        LEFT JOIN tbl_answer ON tbl_question.id = tbl_answer.question_id
        LEFT JOIN tbl_answer_step ON tbl_answer_step.answer_id = tbl_answer.id
        LEFT JOIN tbl_step_master ON tbl_step_master.step_id = tbl_answer_step.step_id';
        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array();
        foreach ($data as $row) {
            if (!isset($results_ary[$row['question_id']])) {
                $results_ary[$row['question_id']] = array(
                    'question_id' => $row['question_id'],
                    'question_content' => $row['question_content'],
                    'question_parent_answer_id' => $row['question_parent_answer_id'],
                    'question_category_id' => $row['question_category_id'],
                    'answers' => array()
                );
            }

            if ($row['answer_id']) {
                $results_ary[$row['question_id']]['answers'][] = array(
                    'answer_id' => $row['answer_id'],
                    'answer_content' => $row['answer_content'],
                    'answer_question_id' => $row['answer_question_id'],
                    'childrens' => $this->getQuestionChild($row['answer_id'])
                );
            }
        }
        var_dump($results_ary); 
        die;


        return $results_ary;
    }

    private function getQuestionChild($parent_answer_id)
    {
        $db = static::getDB();
        $query = 'SELECT tbl_question.id question_id, 
        tbl_question.content question_content, 
        tbl_question.parent_answer_id question_parent_answer_id, 
        tbl_question.category_id question_category_id, 
        tbl_answer.id answer_id, 
        tbl_answer.content answer_content, 
        tbl_answer.question_id answer_question_id, 
        tbl_step_master.step_id, 
        tbl_step_master.step_name
        FROM tbl_question
        LEFT JOIN tbl_answer ON tbl_question.id = tbl_answer.question_id
        LEFT JOIN tbl_answer_step ON tbl_answer_step.answer_id = tbl_answer.id
        LEFT JOIN tbl_step_master ON tbl_step_master.step_id = tbl_answer_step.step_id
        WHERE tbl_question.parent_answer_id = ' . $parent_answer_id . '';
        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array();

        foreach ($data as $row) {

            if (!isset($results_ary[$row['question_id']])) {
                $results_ary[$row['question_id']] = array(
                    'question_id' => $row['question_id'],
                    'question_content' => $row['question_content'],
                    'question_parent_answer_id' => $row['question_parent_answer_id'],
                    'question_category_id' => $row['question_category_id'],
                    'answers' => array()
                );
            }

            if ($row['question_parent_answer_id'] == 0) {
                $results_ary[$row['question_id']]['answers'][] = array(
                    'answer_id' => $row['answer_id'],
                    'answer_content' => $row['answer_content'],
                    'answer_question_id' => $row['answer_question_id'],
                    'childrens' => array(
                        'step_id' => $row['step_id'],
                        'step_name' => $row['step_name']
                    )
                );
            } else {
                $results_ary[$row['question_id']]['answers'][] = array(
                    'answer_id' => $row['answer_id'],
                    'answer_content' => $row['answer_content'],
                    'answer_question_id' => $row['answer_question_id'],
                    'childrens' => array(
                        'step_id' => $row['step_id'],
                        'step_name' => $row['step_name']
                    )
                );
            }
        }
        return $results_ary;
    }

    public function getBy($column, $operator, $value, $select_column = '*')
    {
        return $this->where($column, $operator, $value)->get($select_column);
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
}
