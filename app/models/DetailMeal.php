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

    public function getDetailsByUserAndMeal($meal_id, $user_id = null) {
        $query = $this->table('detail_meal')
            ->join('meal', 'detail_meal.meal_id = meal.id')
            ->join('app_user', 'detail_meal.user_id = app_user.id')
            ->join('food', 'detail_meal.food_id = food.id')
            ->where('meal.id', '=', $meal_id);

        // Only add the user_id condition if a specific userId is provided
        if ($user_id !== null) {
            $query->where('detail_meal.user_id', '=', $user_id);
        }

        $query->orderBy('user_id');

        $select_cols = 'detail_meal.*, '
            . 'meal.time_open, meal.closed, '
            . 'app_user.name as user_name, app_user.display_name, app_user.img_code, '
            . 'food.name as food_name, food.price, food.image';

        return $query->select($select_cols)->get();
    }

    public function updateMealDetail($mealDetailId, $data) {
        $conditions = "id = $mealDetailId";
        return $this->update($data, $conditions);
    }

    public function deleteMealDetail($mealDetailId) {
        $conditions = "id = $mealDetailId";
        return $this->destroy($conditions);
    }

    public function getGeneralDetailMealByMealId($meal_id) {
        $details = array();
        $pdo = parent::getDB();
        $sql = "SELECT d.food_id, d.price,d.describes, SUM(d.amount) as amount, f.name, f.image
        FROM detail_meal d 
        JOIN food f on d.food_id = f.id
        WHERE d.meal_id = ?
        GROUP BY d.food_id, d.describes, d.price
        ORDER BY d.food_id";
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
                'image' => $row['image']
            );
            $details[] = $detail;
        }
        return $details;
    }

    public function getDetailDetailMealByMealId($meal_id) {
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
                    $this->table($this->_table)->update($insertData, "food_id = $foodId " . " AND " . " user_id = $userId ");
                    unset($existingItemsAssoc[$foodId]);
                } else {
                    // Insert new item
                    $this->table($this->_table)->insert($insertData);
                }
            }

            // Delete any items that were not in the submitted data
            foreach ($existingItemsAssoc as $foodId => $item) {
                $this->table($this->_table)->destroy("food_id = $foodId " . " AND " . " user_id = $userId ");
            }

            return ['status' => 'success'];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getDetailMealByMealId($meal_id) {
        $pdo = parent::getDB();
        $sql = "SELECT d.id, d.user_id, d.food_id, d.price, d.amount, d.describes
        FROM detail_meal d 
        WHERE d.meal_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $stmt->execute();
        $details = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detail = array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'price' => $row['price'],
                'food_id' => $row['food_id'],
                'amount' => $row['amount'],
                'describes' => $row['describes'],
            );
            $details[] = $detail;
        }
        return $details;
    }

    public function deleteAllDetailMealByMealId($meal_id) {
        $pdo = parent::getDB();
        $sql = "DELETE FROM detail_meal WHERE meal_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        return $result;
    }

    public function getMealsByUser($user_id) {
        return $this->table($this->_table)
            ->select('meal_id')
            ->where('user_id', '=', $user_id)
            ->groupBy('meal_id')
            ->get();
    }
}
