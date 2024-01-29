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

    public function processOrder($orderData) {
        $userId = $orderData['user_id'];
        $mealId = $orderData['meal_id'];
        $submittedItems = $orderData['items'];

        // Check if meal is closed
        $object_meal = new Meal();
        $meal = $object_meal->find($mealId);
        if ($meal['closed'] == 1 || !isset($meal)) {
            return ['status' => 'meal_closed_or_deleted'];
        }

        // Retrieve existing items from the database
        $existingItems = $this->table($this->_table)
            ->where('meal_id', '=', $mealId)
            ->where('user_id', '=', $userId)
            ->get();

        try {
            // Convert existing items to an associative array for easy lookup
            $existingItemsAssoc = [];
            foreach ($existingItems as $item) {
                $existingItemsAssoc[$item['food_id']] = $item;
            }

            // Process each submitted item
            foreach ($submittedItems as $foodId => $submittedItem) {
                $insertData = [
                    'user_id' => $userId,
                    'meal_id' => $mealId,
                    'food_id' => $foodId,
                    'price' => $submittedItem['price'],
                    'amount' => $submittedItem['quantity'],
                    'describes' => isset($submittedItem['describes']) ? $submittedItem['describes'] : ''
                ];

                if (isset($existingItemsAssoc[$foodId])) {
                    // Update existing item
                    $this->table($this->_table)->update($insertData, "food_id = $foodId");
                    unset($existingItemsAssoc[$foodId]); // Remove from the array to track deletions
                } else {
                    // Insert new item
                    $this->table($this->_table)->insert($insertData);
                }
            }

            // Delete any items that were not in the submitted data
            foreach ($existingItemsAssoc as $foodId => $item) {
                $this->table($this->_table)->destroy("food_id = $foodId");
            }

            return ['status' => 'success'];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
