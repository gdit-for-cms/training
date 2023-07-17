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

    private $_table = 'user';

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
        $db = static::getDB();
        $query = 'SELECT u.id, u.name, u.email, u.role_id, u.room_id, u.position_id, u.gender, u.avatar_image, role.name role_name, room.name room_name, position.name position_name
                    FROM user AS u
                    JOIN role ON u.role_id = role.id
                    JOIN room ON u.room_id = room.id
                    JOIN position ON u.position_id = position.id
                    WHERE u.id =' . $id .
            ' ORDER BY u.id DESC';
        $stmt = $db->query($query);
        $results_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results_ary;
    }

    public function getByRelation($req_method_ary, $name, $results_per_page = 5)
    {
        $db = static::getDB();
        $id = $req_method_ary['id'];

        $query = 'SELECT u.id, u.name, u.email, u.room_id, u.position_id, u.gender, role.name role_name, room.name room_name, position.name position_name
                    FROM user AS u
                    JOIN role ON u.role_id = role.id
                    JOIN room ON u.room_id = room.id
                    JOIN position ON u.position_id = position.id
                    WHERE u.' . $name . '=' . $id .
            ' ORDER BY u.id DESC';

        if ($results_per_page != 'all') {
            if (!isset($req_method_ary['page'])) {
                $req_method_ary['page'] = '1';
            }

            $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
            $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

            $stmt_count = $db->query($query);
            $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
            $stmt = $db->query($query . " " . $limit_query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results);

            return $results_ary;
        } else {
            $stmt = $db->query($query);
            $results_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results_ary;
        }
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }

    public function updateMultiByName($data, $column)
    {
        $condition_query = '';
        $condition_value_name = '';

        foreach ($data as $key => $value) {
            $condition_query .= 'WHEN ' . '\'' . $key . '\'' .  ' THEN ' . $value . ' ';
            if ($condition_value_name == '') {
                $condition_value_name .= '\'' . $key . '\'';
            } else {
                $condition_value_name .= ', ' . '\'' . $key . '\'';
            }
        }
        $db = static::getDB();
        $stmt = $db->query('UPDATE user 
                            SET ' . $column . ' = CASE `name` '
            . $condition_query .
            ' ELSE ' . $column . ' END
                            WHERE `name` IN (' . $condition_value_name . ')');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function destroyOne($condition)
    {
        return $this->destroy($condition);
    }

    public static function getAllRelation($req_method_ary = array(), $results_per_page = 10)
    {
        $db = static::getDB();
        $condition_query = "";

        if (!isset($req_method_ary['page'])) {
            $req_method_ary['page'] = '1';
        }

        $page_first_result = ((int)$req_method_ary['page'] - 1) * $results_per_page;
        $limit_query = 'LIMIT ' . $page_first_result . ',' . $results_per_page;

        unset($req_method_ary['page']);
        foreach ($req_method_ary as $key => $value) {
            if ($condition_query != '') {
                if ($key != 'search') {
                    $condition_query .= ' AND ';
                    $condition_query .= $key . '=' . $value;
                } else {
                    $condition_query .= ' AND ';
                    $condition_query .= '(u.name LIKE \'%' . $value . '%\' OR u.email LIKE \'%' . $value . '%\')';
                }
            } else {
                if ($key != 'search') {
                    $condition_query .= "WHERE $key = $value";
                } else {
                    $condition_query .= 'WHERE (u.name LIKE \'%' . $value . '%\' OR u.email LIKE \'%' . $value . '%\')';
                }
            }
        }

        $query = 'SELECT u.id, u.name, u.email, u.room_id, u.position_id, u.gender, role.name role_name, room.name room_name, position.name position_name
                FROM user AS u
                JOIN role ON u.role_id = role.id
                JOIN room ON u.room_id = room.id
                JOIN position ON u.position_id = position.id '
            . $condition_query .
            ' ORDER BY u.id DESC';

        $stmt_count = $db->query($query);
        $numbers_of_page = count($stmt_count->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . ' ' . $limit_query);
        $results_query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_ary = array('numbers_of_page' => $numbers_of_page, 'results' => $results_query);

        return $results_ary;
    }

    public function rules($change = '', $value = array())
    {
        $rules_ary = array(
            'name' => array(
                'required',
                'name',
                'filled',
                'maxLen:30',
            ),
            'email' => array(
                'required',
                'email',
                'filled',
            ),
            'gender' => array(
                'required',
                'gender'
            ),
            'password' => array(
                'required',
                'password',
                'filled',
                'minLen:8',
            ),
            'role_id' => array(
                'required',
            ),
            'room_id' => array(
                'required',
            ),
            'position_id' => array(
                'required',
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
}