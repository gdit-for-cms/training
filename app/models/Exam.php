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
class Exam extends Model
{
    use QueryBuilder;

    private $_table = 'exam';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function getAll()
    {
        return (new self)->latest()->get();
    }

    public function getById($id)
    {
        return $this->where('id', "=", $id)->get('*')[0];
    }

    public function getExamsWithQuestions($id='')
    {
        $db = static::getDB();

        // Thực hiện câu truy vấn để lấy thông tin bài thi và câu hỏi liên quan
        $query = "SELECT e.id AS exam_id, e.title AS exam_title, e.description AS exam_description,
       q.id AS question_id, q.content AS question_content, q.title as question_title
FROM exam AS e
LEFT JOIN exam_questions AS qe ON e.id = qe.exam_id
LEFT JOIN question AS q ON qe.question_id = q.id
";

        $db = static::getDB();
        $stmt = $db->query($query);
        $results_ary = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // var_dump($results_ary);
        // die();
        // Tạo một mảng để gom nhóm các câu hỏi theo bài thi
        // $exams = [];
        // foreach ($results_ary as $row) {
        //     $examId = $row['exam_id'];

        //     // Nếu chưa tồn tại bài thi trong mảng $exams, thêm mới
        //     if (!isset($exams[$examId])) {
        //         $exams[$examId] = [
        //             'exam_id' => $row['exam_id'],
        //             'exam_title' => $row['exam_title'],
        //             'exam_description' => $row['exam_description'],
        //             'questions' => []
        //         ];
        //     }

        //     // Nếu câu hỏi có ID, thêm vào danh sách câu hỏi của bài thi
        //     if ($row['question_id']) {
        //         $exams[$examId]['questions'][] = [
        //             'question_id' => $row['question_id'],
        //             'question_content' => $row['question_content']
        //         ];
        //     }
        // }

        // Kết quả sẽ là mảng $exams, trong đó mỗi phần tử là thông tin một bài thi kèm danh sách câu hỏi
        // echo "<pre>";
        // var_dump($exams);
        // die();
        return $results_ary;
    }
}
