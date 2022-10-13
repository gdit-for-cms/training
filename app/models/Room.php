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
class Room extends Model
{
    use QueryBuilder;
    private $_table = 'room';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function all()
    {
        return (new self)->all();
    }

    public static function create($data)
    {
        return (new self)->insert($data);
    }

    public static function getBy($column, $operator, $value)
    {   
        return (new self)->where($column, $operator, $value)->get();
    }

    public static function getById($id, $column)
    {   
        return (new self)->find($id, $column);
    }

    public static function update($data, $condition)
    {
        return (new self)->update($data, $condition);
    }

    public static function destroy($condition)
    {
        return (new self)->destroy($condition);
    }
}
