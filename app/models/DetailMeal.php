<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use Core\Http\Request;
use PDO;

class DetailMeal extends Model {
    use QueryBuilder;

    private $_table = 'detail_meal';

    public function createMealDetail($userId, $mealId, $foodId, $price, $description, $amount) {
        $data = [
            'user_id' => $userId,
            'meal_id' => $mealId,
            'food_id' => $foodId,
            'price' => $price,
            'describes' => $description,
            'amount' => $amount
        ];

        return $this->insert($data);
    }

    public function getDetailsByUserAndMeal($mealId, $userId) {
        $this->table('detail_meal')
            ->join('meal', 'detail_meal.meal_id = meal.id')
            ->join('app_user', 'meal.user_id = app_user.id')
            ->join('food', 'detail_meal.food_id = food.id')
            ->where('meal.id', '=', $mealId)
            ->where('meal.user_id', '=', $userId);

        $selectColumns = 'detail_meal.*, '
            . 'meal.time_open, meal.closed, '
            . 'app_user.name as user_name, app_user.display_name, app_user.img_code, '
            . 'food.name as food_name, food.price, food.image';

        return $this->select($selectColumns)->get();
    }
    public function updateMealDetail($mealDetailId, $data) {
        $conditions = "id = $mealDetailId";
        return $this->update($data, $conditions);
    }

    public function deleteMealDetail($mealDetailId) {
        $conditions = "id = $mealDetailId";
        return $this->destroy($conditions);
    }

    function getGenerallDetailMealByMealId($meal_id) {
        $details = array();
        $pdo = parent::getDB();
        $sql = "SELECT d.food_id, d.price,d.describes, SUM(d.amount) as amount, f.name, f.image, GROUP_CONCAT(d.describes SEPARATOR' - ') as describes
        FROM detail_meal d 
        JOIN food f on d.food_id = f.id
        WHERE d.meal_id = ?
        GROUP BY d.food_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detail = array(
                'food_id' => $row['food_id'],
                'price' => $row['price'],
                'describes' => $row['describes'],
                'amount' => $row['amount'],
                'name' => $row['name'],
                'image' => $row['image'],
                'describes_concatenated' => $row['describes']
            );
            $details[] = $detail;
        }
        return $details;
    }
    function getDetailDetailMealByMealId($meal_id) {
        $pdo = parent::getDB();
        $sql = "SELECT d.food_id, d.price,d.describes, d.amount, f.name, f.image, d.describes, a.display_name
        FROM detail_meal d 
        JOIN food f on d.food_id = f.id
        JOIN app_user a on d.user_id = a.id
        WHERE d.meal_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        return $result;
    }
}
