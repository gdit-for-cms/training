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
class User extends Model {
    use QueryBuilder;

    private $_table = 'app_user';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public function getAll() {
        return $this->all();
    }

    public function getBy($column, $operator, $value, $select_column = '*') {
        return $this->where($column, $operator, $value)->get($select_column);
    }

    public function getImgBy($column, $operator, $value) {
        return $this->where($column, $operator, $value)->get();
    }

    public function create($data) {
        return $this->insert($data);
    }

    public function updateOne($data, $condition) {
        return $this->update($data, $condition);
    }

    public function destroyOne($condition) {
        return $this->destroy($condition);
    }

    public function rules($change = '', $value = array()) {
        $rules_ary = array(
            'name' => array(
                'required',
                'name',
                'filled',
                'maxLen:30',
            ),
            'pass' => array(
                'required',
                'pass',
                'filled',
                'minLen:8',
            ),
            'display_name' => array(
                'required',
                'display_name',
                'filled',
                'maxLen:30',
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
