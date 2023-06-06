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
class PermissionRoom extends Model
{
    use QueryBuilder;

    private $_table = 'permission_room';
    public object $permission;
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public function __construct()
    {
        $this->permission = new Permission;
    }
    public static function getAll()
    {
        return (new self)->all();
    }

    public function create($data)
    {
        return $this->insert($data);
    }
    public function destroyOne($condition)
    {
        return $this->destroy($condition);
    }
    public static function getPermissionIdsByRoomId($room_id)
    {
        $db = static::getDB();
        $query = "SELECT permission_id FROM permission_room WHERE room_id='$room_id'";
        $result = $db->query($query);
        if ($result) {
            $result_ary = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $result_ary[] = $row['permission_id'];
            }
            return $result_ary;
        }
        return false;
    }

    public function destroyByRoomId($room_id)
    {
        $db = static::getDB();
        $query = "DELETE FROM permission_room WHERE room_id='$room_id'";
        $result = $db->query($query);
        return $result;
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function getById($id, $column)
    {
        return $this->find($id, $column);
    }
}