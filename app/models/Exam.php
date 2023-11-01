<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;

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
        return $this->where('id', "=", $id)->get()[0];
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

    public function getExam($req_method_ary, $results_per_page = 10)
    {
        if (!isset($req_method_ary['page']) || ($req_method_ary['page'] < 1)) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;

        //filter status
        if (isset($req_method_ary['status'])) {
            $currentTime = time();
            $dateTime = date("Y-m-d H:i:s", $currentTime);
            $array_status = [1, 2, 3];
            // where (condition1 OR condition2 OR condition3) AND condition4
            if ($req_method_ary['status'] == 1) {
                $this->where(" (" . "exam.time_start", ">", $dateTime)
                    ->orWhereNull("exam.time_start")
                    ->orWhere("exam.published", "!=", "1");
            } else if ($req_method_ary['status'] == 2) {
                $this->where(" (" . "exam.time_start", "<=", "$dateTime")
                    ->Where("exam.time_end", ">=", $dateTime)
                    ->Where("exam.published", "=", "1");
            } else if ($req_method_ary['status'] == 3) {
                $this->where(" (" . "exam.time_end ", "<", $dateTime);
            }

            if (in_array($req_method_ary['status'], $array_status)) {
                $this->where =  $this->where . ")";
            }
        }

        //filter publish
        if (isset($req_method_ary['publish'])) {
            if ($req_method_ary['publish'] == 1) {
                $this->where("exam.published", "=", 1);
            } else if ($req_method_ary['publish'] == 0) {
                $this->where("exam.published", "=", 0);
            }
        }

        //filter search keyword
        $keyword_search = "";
        if (isset($req_method_ary['keyword'])) {
            $keyword_search = htmlspecialchars(trim($req_method_ary['keyword']));
            $this->whereLikeWithSpecialCharEscape("exam.title", $keyword_search);
        }

        // limit
        $this->orderBy("exam.id", "desc");
        if ($keyword_search == "") {
            $this->limit($results_per_page, $page_first_result);
        }
        $where = $this->where;
        // get number of page
        $results = $this->get("exam.id, exam.title, exam.description, exam.published, exam.uploaded_at, exam.time_start, exam.time_end, exam.updated_at");

        //get number of page
        $numbers_of_page = count($this->getAll());
        if (isset($req_method_ary['status']) || isset($req_method_ary['publish'])) {
            $this->where = $where;
            $numbers_of_page = count($this->get("exam.id"));
        }

        return array(
            'numbers_of_page' => $numbers_of_page,
            'results' => $results,
            'page' => $req_method_ary['page']
        );
    }

    public function rules($change = '', $value = array())
    {
        $rules_ary = array(
            'title' => array(
                'required',
                'filled',
                'maxLen:255',
            ),
            'description' => array(
                'maxLen:5000'
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

    public function create($data)
    {
        return $this->insert($data);
    }

    function beginTransaction()
    {
        return $this->getDB()->beginTransaction();
    }

    function commitTransaction()
    {
        return $this->getDB()->commit();
    }

    function rollBackTransaction()
    {
        $db = static::getDB();
        return $db->rollBack();
    }
}
