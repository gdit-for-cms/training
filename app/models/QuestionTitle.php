<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class QuestionTitle extends Model
{
    use QueryBuilder;

    private $_table = 'question_title';

    /**
     * Get all the questions as an associative array
     *
     * @return array
     */

    public static function getAll()
    {
        return (new self)->latest()->get();
    }
}
