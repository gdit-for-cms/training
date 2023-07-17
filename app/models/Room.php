<?php

namespace App\Models;

use Core\Model;
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

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function getById($id, $column = '*')
    {
        return $this->find($id, $column);
    }

    public function updateOne($data, $condition)
    {
        return $this->update($data, $condition);
    }

    public function destroyOne($condition)
    {
        return $this->destroy($condition);
    }
    public static function getPermissionsAccess($id)
    {
        return PermissionRoom::getPermissionByRoom($id);
    }

    public static function rules($change = '', $value = [])
    {
        $rules_ary = [
            'name' => [
                'required',
                'name',
                'filled',
            ],
            'description' => [
                'max:2000',
            ],
        ];

        switch ($change) {
            case 'add':
                return array_merge($rules_ary, $value);
                break;
            case 'remove':
                foreach ($value as $each) {
                    if (array_key_exists($each, $rules_ary)) {
                        unset($rules_ary[$each]);
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
