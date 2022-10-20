<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\QueryBuilder;

class Question extends Model
{
    use QueryBuilder;
    private $_table = 'question';

    public static function all()
    {
        
        $db = static::getDB();
        $stmt = $db->query('SELECT e.*, t.name topic_name FROM `exam_model` AS e JOIN `topic` AS t ON e.topic_id = t.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * insert into 3 table(question, question_detail, exam_detail)
     *
     * @return boolean
     */
    public static function create($name, $type, $answer, $opt1, $opt2, $opt3, $opt4)
    {
        $db = static::getDB();
        $str = "(SELECT id FROM question WHERE name= '$name')";
        $stmt = $db->query(
        "INSERT INTO `question`(name, type, answer)
        VALUES ('$name', '$type', $answer);
        INSERT INTO `question_detail`(question_id, opt_content)
        VALUES ($str, '$opt1'), ($str, '$opt2'), ($str, '$opt3'), ($str, '$opt4');");
        return $stmt;
    }

    public static function updateQuestion($data)
    {
        return (new self)->update($data);
    }

    public static function getId($name)
    {
        return (new self)->where('name', '=', $name)->get('id');
    }

    public static function delete($id)
    {
        return (new self)->destroy("id = $id");
    }

    public static function checkExist($name)
    {
        $db = static::getDB();
        $name = addslashes(htmlspecialchars($name));
        $stmt = $db->query("SELECT EXISTS(SELECT * FROM `question` WHERE name = '$name') AS mycheck LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }
}
