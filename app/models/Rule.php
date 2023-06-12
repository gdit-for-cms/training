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
class Rule extends Model
{
    use QueryBuilder;

    private $_table = 'rules';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public function getAll()
    {
        return $this->all();
    }

    public function getBy($column, $operator, $value, $select_column = '*')
    {
        return $this->where($column, $operator, $value)->get($select_column);
    }

    public function getById($id)
    {
        return $this->where('id', "=", $id)->get('*')[0];
    }

    public static function getAllRelation($req_method_ary = array(), $results_per_page = 5)
    {

        $db = static::getDB();
        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }
        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        unset($req_method_ary['page']);
        foreach ($req_method_ary as $key => $value) {
            $req_method_ary[$key] = self::removeSpecialChar($value);
        }
        // var_dump($req_method_ary);
        // die;

        $condition_ary = array();
        if (!empty($req_method_ary['date_search'])) {
            array_push($condition_ary, '(Date(r.created_at) =\'' . $req_method_ary['date_search'] . '\')');
        }
        if (!empty($req_method_ary['category'])) {
            array_push($condition_ary, '(r.large_category =\'' . $req_method_ary['category'] . '\' OR r.middle_category =\'' . $req_method_ary['category'] . '\'OR r.small_category=\'' . $req_method_ary['category'] . '\')');
        }
        if (!empty($req_method_ary['search'])) {
            array_push($condition_ary, ' (r.large_category LIKE \'%' . $req_method_ary['search'] . '%\' OR r.middle_category LIKE \'%' . $req_method_ary['search'] . '%\'OR r.small_category LIKE \'%'
                . $req_method_ary['search'] . '%\'OR r.content LIKE \'%' . $req_method_ary['search'] . '%\'OR r.detail LIKE \'%' . $req_method_ary['search'] . '%\'OR r.note LIKE \'%' . $req_method_ary['search'] . '%\')');
        }
        $where_condiditon = implode('AND', $condition_ary);
        if ($where_condiditon != '') {
            $where_condiditon = 'WHERE' . $where_condiditon;
        }
        $query = 'SELECT *
                FROM rules AS r
                '
            . $where_condiditon;

        $stmt_count = $db->query($query);
        $numbers_of_result = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . ' ' . $limit_query);
        $results_query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_result' => $numbers_of_result, 'results' => $results_query);

        return $results_ary;
    }

    public static function getAllCategories($type_rule_id)
    {
        $db = static::getDB();
        $query_large_category = "SELECT large_category FROM rules WHERE type_rule_id = '$type_rule_id' GROUP BY large_category";
        $query_middle_category = "SELECT middle_category FROM rules WHERE type_rule_id = '$type_rule_id' GROUP BY middle_category";
        $query_small_category = "SELECT small_category FROM rules WHERE type_rule_id = '$type_rule_id' GROUP BY small_category";
        $large_categories = $db->query($query_large_category)->fetchAll(PDO::FETCH_ASSOC);
        $middle_categories = $db->query($query_middle_category)->fetchAll(PDO::FETCH_ASSOC);
        $small_categories = $db->query($query_small_category)->fetchAll(PDO::FETCH_ASSOC);

        $all_categories = array();
        foreach ($large_categories as $key => $value) {
            $all_categories[] = $value['large_category'];
        }
        foreach ($middle_categories as $key => $value) {
            $all_categories[] = $value['middle_category'];
        }
        foreach ($small_categories as $key => $value) {
            $all_categories[] = $value['small_category'];
        }

        return $all_categories;
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
    public static function removeSpecialChar($string)
    {
        $replace = array('UNION', 'SELECT', 'AND', 'OR', '=', '_', '-', '&', '+', '*', '`', '~', '#', '?', '<', '>', '(', ')', '%', '!', "'", "'", ";");
        return str_replace($replace, '', preg_replace('/[^a-zA-Z0-9]/', "", $string));
    }
}
