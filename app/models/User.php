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
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT u.id, u.name, u.email, u.room_id, role.name role_name, room.name room_name
                            FROM user AS u
                            JOIN role ON u.role_id = role.id
                            JOIN room ON u.room_id = room.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDataFollowRole($role_id)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM user WHERE role_id = $role_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
