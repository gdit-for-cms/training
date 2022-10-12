<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\Http\Session;
use Core\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends Model
{
    use QueryBuilder;
    private $_table = 'user';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAllRelation()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT u.id, u.name, u.email, u.room_id, u.position_id, role.name role_name, room.name room_name, position.name position_name
                            FROM user AS u
                            JOIN role ON u.role_id = role.id
                            JOIN room ON u.room_id = room.id
                            JOIN position ON u.position_id = position.id');
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
