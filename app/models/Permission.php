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
class Permission extends Model {
    use QueryBuilder;

    private $_table = 'permissions';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll() {
        return (new self)->all();
    }


    public function create($data) {
        return $this->insert($data);
    }

    public function getBy($column, $operator, $value) {
        return $this->where($column, $operator, $value)->get();
    }

    public function getById($id, $column) {
        return $this->find($id, $column);
    }
}