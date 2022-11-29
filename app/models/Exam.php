<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\QueryBuilder;

class Exam extends Model
{
    use QueryBuilder;
    private $_table = 'exam_model';

    /**
     * check the existence of exam name
     *
     * @return string
     */
    public static function checkExist($name) {
        $db = static::getDB();
        $name = addslashes(htmlspecialchars($name));
        $stmt = $db->query('SELECT EXISTS(SELECT * FROM `Exam` WHERE name = \''. $name . '\') AS mycheck LIMIT 1');
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function all() {
        $db = static::getDB();
        $stmt = $db->query('SELECT e.*, t.name topic_name FROM `exam_model` AS e JOIN `topic` AS t ON e.topic_id = t.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        return (new self)->insert($data);
    }
    
    
    public static function createDetail($data) {
        return (new self)->insert($data);
    }

    public static function updateTopic($data) {
        return (new self)->update($data);
    }

    public static function getId($name) {
        return (new self)->where('name', '=', $name)->get('id');
    }

    public static function getCountQuestion($id) {
        return (new self)->where('id', '=', $id)->get('count_q');
    }

    public static function getCreatedQuestion($id) {
        $db = static::getDB();
        $stmt = $db->query('SELECT count(*) as `created` FROM `exam_detail` where `exam_id` = ' . $id);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        return (new self)->destroy("id = $id");
    }
}
