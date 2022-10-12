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
class Position extends Model
{
    use QueryBuilder;
    private $_table = 'position';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function allPosition()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM `position` ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDataBy($column, $operator, $value)
    {   
        return (new self)->where($column, $operator, $value)->get();
    }

    public static function getDataById($id, $column)
    {   
        return (new self)->find($id, $column);
    }

    public static function insertData($data)
    {
        return (new self)->insert($data);
    }

    public static function updateData($data, $condition)
    {
        return (new self)->update($data, $condition);
    }

    public static function destroyData($condition)
    {
        return (new self)->destroy($condition);
    }

}