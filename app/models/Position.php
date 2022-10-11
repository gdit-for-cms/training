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
class Position extends Model
{
    use QueryBuilder;
    private $_table = 'position';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function All()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM `position` ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}