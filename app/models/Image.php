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
class Image extends Model
{
    use QueryBuilder;

    private $_table = 'library_images';
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

    public static function getAllRelation($req_method_ary = array(), $limit = 5)
    {
        $db = static::getDB();
        foreach ($req_method_ary as $key => $value) {
            $req_method_ary[$key] = self::filterSqlInJection($value);
        }
        $condition_ary = array();
        $limit_query = 'LIMIT ' . $limit;
        if (!empty($req_method_ary['keyword'])) {
            array_push($condition_ary, ' (l.name  LIKE \'%' . $req_method_ary['keyword'] . '%\' OR l.path LIKE \'%' . $req_method_ary['keyword'] . '%\')');
        }
        $where_condiditon = implode('AND', $condition_ary);
        if ($where_condiditon != '') {
            $where_condiditon = 'WHERE' . $where_condiditon;
        }
        $query = 'SELECT *
                FROM library_images as l
                '
            . $where_condiditon;
        $stmt_count = $db->query($query);
        $numbers_of_result = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . ' ' . $limit_query);
        $results_query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_result' => $numbers_of_result, 'images' => $results_query);
        return $results_ary;
    }

    public function getById($id, $column)
    {
        return $this->find($id, $column);
    }
    public static function filterSqlInJection($string)
    {
        $replace = array('UNION', 'SELECT', 'AND', 'OR', '=', '_', '-', '&', '+', '*', '`', '~', '#', '?', '<', '>', '(', ')', '%', '!', "'", "'", ";");
        return str_replace($replace, '', $string);
    }
}
