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
class Topic extends Model
{
    use QueryBuilder;
    private $_table = 'topic';

    /**
     * check the existence of topic name
     *
     * @return string
     */
    public static function checkExist($name)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT EXISTS(SELECT * FROM topic WHERE name = '$name') AS mycheck LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }

    public static function all()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM `topic` ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name)
    {
        $model = new Topic();
        return $model->insert([
            'name' => $name, 
        ]);
    }

    public static function delete($name)
    {
        // $model = new Topic();
        // return self::insert([
        //     'name' => $name, 
        // ]);
    }
}
