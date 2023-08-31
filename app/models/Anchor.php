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
class Anchor extends Model
{
    use QueryBuilder;

    private $_table = 'anchor_name';
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        return (new self)->all();
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function create($data)
    {
        return $this->insert($data);
    }
}