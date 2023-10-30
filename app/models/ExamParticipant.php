<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class ExamParticipant extends Model
{
    use QueryBuilder;

    private $_table = 'exam_participants';

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

    public function getBy($column, $operator, $value, $selectColumn = '*')
    {
        return $this->where($column, $operator, $value)->get($selectColumn);
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function getColumn($column, $operator, $value, $get_columns = "*")
    {
        return $this->where($column, $operator, $value)->get($get_columns);
    }

    public function getParticipant($column, $operator, $value, $order_column, $direction = "desc")
    {
        return $this->where($column, $operator, $value)->orderBy($order_column, $direction)->get();
    }

    public function getExam($participant_id)
    {
        return $this->join(" exam as e", "e.id = " . $this->_table . ".exam_id")
            ->where($this->_table . ".id", "=", $participant_id)
            ->get("e.id, e.title, e.time_start, e.time_end")[0];
    }

    public function rules($change = '', $value = array())
    {
        $rules_ary = array(
            'email' => array(
                'email',
            ),
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
}
