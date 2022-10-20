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
class User extends Model
{
    use QueryBuilder;

    public $rules = [
        'name' => [
            'required',
            'string',
            'filled',
            'maxLen:20',
            'minLen:5',
        ],
        'email' => [
            'required',
            'string',
            'filled',
        ],
        'password' => [
            'required',
            'string',
            'filled',
        ],
        'role_id' => [
            'required',
        ],
        'room_id' => [
            'required',
        ],
        'position_id' => [
            'required',
        ],
    ];

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
                            JOIN position ON u.position_id = position.id
                            ORDER BY u.id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBy($column, $operator, $value)
    {
        return (new self)->where($column, $operator, $value)->get();
    }

    public static function getById($id, $column)
    {
        return (new self)->find($id, $column);
    }

    public static function create($data)
    {
        return (new self)->insert($data);
    }

    public static function updateOne($data, $condition)
    {
        return (new self)->update($data, $condition);
    }

    public static function destroyOne($condition)
    {
        return (new self)->destroy($condition);
    }

    public static function filter($array)
    {
        $db = static::getDB();
        $condition = "";
        // var_dump($array);
        // exit;
        foreach ($array as $key => $value) {
            if ($condition != "") {
                if ($key != 'search') {
                    # code...
                    $condition .= " AND ";
                    $condition .= "$key = $value";
                } else {
                    $condition .= " AND ";
                    $condition .= "(u.name LIKE '%$value%' OR u.email LIKE '%$value%')";
                }
            } else {
                if ($key != 'search') {
                    $condition .= "WHERE $key = $value";
                } else {
                    $condition .= "WHERE (u.name LIKE '%$value%' OR u.email LIKE '%$value%')";
                }
            }
        } 

        $stmt = $db->query("SELECT u.id, u.name, u.email, u.room_id, u.position_id, role.name role_name, room.name room_name, position.name position_name
                            FROM user AS u
                            JOIN role ON u.role_id = role.id
                            JOIN room ON u.room_id = room.id
                            JOIN position ON u.position_id = position.id
                            $condition
                            ORDER BY u.id DESC");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'filled',
                'maxLen:20',
                'minLen:5',
            ],
            'email' => [
                'required',
                'string',
                'filled',
            ],
            'password' => [
                'required',
                'string',
                'filled',
            ],
            'role_id' => [
                'required',
            ],
            'room_id' => [
                'required',
            ],
            'position_id' => [
                'required',
            ],
        ];
    }
}
