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

    public function getResultJson() 
    {
        return json_encode($this->getQuestion());
    }

    private function getQuestion($parent_answer_id = 0)
    {
        $db = static::getDB();
        $query = 'SELECT q1.id AS question_id, q1.content AS question_content, q1.parent_answer_id,
        a1.id AS answer_id, a1.content AS answer_content,
        s1.step_id, s1.step_name
        FROM tbl_question q1
        LEFT JOIN tbl_answer a1 ON q1.id = a1.question_id
        LEFT JOIN tbl_answer_step as1 ON a1.id = as1.answer_id
        LEFT JOIN tbl_step_master s1 ON as1.step_id = s1.step_id
        WHERE parent_answer_id =' . $parent_answer_id . '
        ORDER BY q1.id, a1.id, s1.step_id';

        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result = $this->buildHierarchy($result, $row);
        }

        return $result;
    }
    
    private function buildHierarchy($result, $row)
    {
        if (!isset($result[$row['question_id']])) {
            $result[$row['question_id']] = [
                'question_id' => $row['question_id'],
                'question_content' => $row['question_content'],
                'parent_answer_id' => $row['parent_answer_id'],
                'answers' => [],
            ];
        }
        if (!empty($row['step_id'])) {
            if (!isset($result[$row['question_id']]['answers'][$row['answer_id']])) {
                $result[$row['question_id']]['answers'][$row['answer_id']] = [
                    'answer_id' => $row['answer_id'],
                    'answer_content' => $row['answer_content'],
                    'steps' => [],
                ];
            }

            if (!empty($row['step_id'])) {
                $result[$row['question_id']]['answers'][$row['answer_id']]['steps'][] = [
                    'step_id' => $row['step_id'],
                    'step_name' => $row['step_name'],
                ];
            }
        } else {
            if (!isset($result[$row['question_id']]['answers'][$row['answer_id']])) {
                $result[$row['question_id']]['answers'][$row['answer_id']] = [
                    'answer_id' => $row['answer_id'],
                    'answer_content' => $row['answer_content'],
                    'questions' => [],
                ];
            }

            $result[$row['question_id']]['answers'][$row['answer_id']]['questions'] = $this->getQuestion($row['answer_id']);
        }

        return $result;
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
