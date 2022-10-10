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
class Role extends Model
{
    use QueryBuilder;

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function All()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM `role` ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}