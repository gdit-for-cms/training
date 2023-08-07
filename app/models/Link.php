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
class Link extends Model
{
    use QueryBuilder;

    private $_table = 'library_file';
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        return (new self)->all();
    }


    public function create($data)
    {
        return $this->insert($data);
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public static function getAllRelation($req_method_ary = array(), $limit)
    {
        $db = static::getDB();
        $condition_ary = array();
        $update_date_order_query = '';
        if (!empty($req_method_ary['update-date-order'])) {
            $update_date_order_query =  ' ORDER BY updated_at ' . $req_method_ary['update-date-order'];
        }
        $limit_query = ' LIMIT ' . $limit;
        if (!empty($req_method_ary['keyword'])) {
            array_push($condition_ary, ' (i.name  LIKE \'%' . $req_method_ary['keyword'] . '%\')');
        }
        $thumbnail = $req_method_ary['thumbnail'];
        $where_condiditon = implode('AND', $condition_ary);
        if ($where_condiditon != '') {
            $where_condiditon = 'WHERE' . $where_condiditon;
        }
        $query = 'SELECT *
                FROM library_file as i
                '
            . $where_condiditon;
        $stmt_count = $db->query($query);
        $numbers_of_result = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . ' ' . $update_date_order_query . $limit_query);
        $results_query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_result' => $numbers_of_result, 'file' => $results_query, 'thumbnail' => $thumbnail);
        return $results_ary;
    }

    public function destroyBy($condition)
    {
        return $this->destroy($condition);
    }

    public function getById($id, $column)
    {
        return $this->find($id, $column);
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }

    public function searchBy($search, $order)
    {
        $db = static::getDB();
        
        $where = $this->whereLike('name', $search);
        
        $query = "SELECT * 
                  FROM library_file ";
        $query .= $where->where;
        $query .= " ORDER BY updated_at";
        if($order == 'descending') {
            $query .= " DESC";
        }

        $query .= " LIMIT 5";

        $stmt = $db->query($query);

        // Lấy kết quả
        $result_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_ary;
    }

    public function searchAll($search)
    {
        $db = static::getDB();

        $where = $this->whereLike('name', $search);

        $query = "SELECT * 
                  FROM library_file ";

        $query .= $where->where;

        $stmt = $db->query($query);

        // Lấy kết quả
        $result_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_ary;
    }

    public function getByQty($qty, $search, $desc)
    {
        $db = static::getDB();

        $where = $this->whereLike('name', $search);

        $query = "SELECT * 
                  FROM library_file ";
        $query .= $where->where;
        $query .= " ORDER BY updated_at";

        if($desc == 'true') {
            $query .= " DESC";
        }

        $query .= " LIMIT $qty";

        $stmt = $db->query($query);

        // Lấy kết quả
        $result_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_ary;
    }

    public function getValueForPaginate($current_page, $limit, $search, $desc)
    {
        $db = static::getDB();

        $where = $this->whereLike('name', $search);

        $query = "SELECT * 
                  FROM library_file ";
        $query .= $where->where;
        $query .= " ORDER BY updated_at";

        if($desc == 'true') {
            $query .= " DESC";
        }

        $query .= " LIMIT $current_page, $limit";

        $stmt = $db->query($query);

        // Lấy kết quả
        $result_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_ary;
    }
}
