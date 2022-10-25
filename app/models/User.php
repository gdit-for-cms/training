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

    public function getBy($column, $operator, $value, $selectColumn = "*")
    {
        return $this->where($column, $operator, $value)->get($selectColumn);
    }

    public function getById($id, $column)
    {
        return $this->find($id, $column);
    }

    public function getByRelation($array = array(), $name, $resultsPerPage = 5)
    {      
        $id = $array['id'];
        
        if (!isset($post['page'])) {
            $post['page'] = '1';
        }

        $pageFirstResult = ((int)$array['page'] - 1)*$resultsPerPage;
        $limitQuery = 'LIMIT ' . $pageFirstResult . ',' . $resultsPerPage;

        $db = static::getDB();

        $query = "SELECT u.id, u.name, u.email, u.room_id, u.position_id, role.name role_name, room.name room_name, position.name position_name
                FROM user AS u
                JOIN role ON u.role_id = role.id
                JOIN room ON u.room_id = room.id
                JOIN position ON u.position_id = position.id
                WHERE u.$name = $id
                ORDER BY u.id DESC";

        $stmtCount = $db->query($query);
        $numbersOfPage = count($stmtCount->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . " " . $limitQuery);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['numbersOfPage' => $numbersOfPage, 'results' => $results];
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
        $conditionQuery = '';
        $conditionValueName = '';
        foreach ($data as $key => $value) {
            $conditionQuery .= "WHEN '$key' THEN $value ";
            if ($conditionValueName == '') {
                $conditionValueName .= "'$key'";
            } else {
                $conditionValueName .= ", '$key'";
            }
        }
        $db = static::getDB();
        $stmt = $db->query("UPDATE user 
                            SET `$column` = CASE `name` " . 
                            $conditionQuery . 
                            " ELSE `$column` END
                            WHERE `name` IN ($conditionValueName)");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function destroyOne($condition)
    {
        return $this->destroy($condition);
    }

    public static function getAllRelation($array = array(), $resultsPerPage = 10)
    {
        $db = static::getDB();
        $conditionQuery = "";

        if (!isset($array['page'])) {
            $array['page'] = '1';
        }
        
        $pageFirstResult = ((int)$array['page'] - 1)*$resultsPerPage;
        $limitQuery = 'LIMIT ' . $pageFirstResult . ',' . $resultsPerPage;

        unset($array['page']);
        foreach ($array as $key => $value) {
            if ($conditionQuery != "") {
                if ($key != 'search') {
                    $conditionQuery .= " AND ";
                    $conditionQuery .= "$key = $value";
                } else {
                    $conditionQuery .= " AND ";
                    $conditionQuery .= "(u.name LIKE '%$value%' OR u.email LIKE '%$value%')";
                }
            } else {
                if ($key != 'search') {
                    $conditionQuery .= "WHERE $key = $value";
                } else {
                    $conditionQuery .= "WHERE (u.name LIKE '%$value%' OR u.email LIKE '%$value%')";
                }
            }
        } 

        $query = "SELECT u.id, u.name, u.email, u.room_id, u.position_id, role.name role_name, room.name room_name, position.name position_name
                FROM user AS u
                JOIN role ON u.role_id = role.id
                JOIN room ON u.room_id = room.id
                JOIN position ON u.position_id = position.id
                $conditionQuery
                ORDER BY u.id DESC";

        $stmtCount = $db->query($query);
        $numbersOfPage = count($stmtCount->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $db->query($query . " " . $limitQuery);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['numbersOfPage' => $numbersOfPage, 'results' => $results];
    }

    public function rules($change = '', $value = [])
    {   
        $rules = [
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
        switch ($change) {
            case 'add':
                return array_merge($rules, $value);
                break;
            case 'remove':
                foreach ($value as $each) {
                    if (array_key_exists($each, $rules)) {
                        unset($rules[$each]);
                    } 
                } 
                return $rules;
                break;
            case 'replace':
                return $value;
                break;
            default:
                return $rules;
                break;
        }
    }
}
