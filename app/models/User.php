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
        // $db = static::getDB();
        // $stmt = $db->query('SELECT id, name FROM users');
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
