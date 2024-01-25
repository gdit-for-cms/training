<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\QueryBuilder;
use DateTime;
use Core\Http\Request;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Meal extends Model {
    use QueryBuilder;

    private $_table = 'meal';

    public function create($url) {
        $store = new Store();
        $store_id = $store->checkLink($url);
        if ($store_id === -1) {
            return FALSE;
        }
        $request = new Request;
        $user = $request->getUser();
        if ($this->createMeal($user['id'], $store_id)) {
            return TRUE;
        }
        return FALSE;
    }

    public function createMeal($userId, $storeId) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO meal (user_id, store_id, time_open, closed) VALUES (?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $currentDateTime = new DateTime();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $storeId);
        $stmt->bindParam(3, $currentDateTimeString);
        $result = $stmt->execute();
        return $result;
    }

    public function closeMeal($mealId) {
        $data = ['closed' => 1]; // Set closed flag to 1
        $conditions = "id = $mealId";

        return $this->update($data, $conditions);
    }

    public function getMealById($mealId) {
        return $this->find($mealId);
    }

    public function getAllOpenMeals() {
        $this->table($this->_table)
            ->join('app_user', 'meal.user_id = app_user.id')
            ->join('store', 'meal.store_id = store.id')
            ->where('meal.closed', '=', 0);

        $selectColumns = 'meal.id, meal.user_id, meal.store_id, meal.time_open as time_open, meal.closed, '
            . 'app_user.name as user_meal_name, app_user.display_name as user_meal_display_name, app_user.img_code as user_meal_code, '
            . 'store.name as store_meal_name, store.link as store_meal_link, store.update_date, store.image as store_meal_img';

        return $this->select($selectColumns)->get();
    }

    public function getMealsByUser($userId) {
        return $this->where('user_id', '=', $userId)->get();
    }

    public function getOpenMealsByUser($userId) {
        return $this->where('user_id', '=', $userId)
            ->where('closed', '=', 0)
            ->get();
    }

    public function getAllMeals() {
        return $this->all();
    }

    public function updateMeal($mealId, $data) {
        $conditions = "id = $mealId";
        return $this->update($data, $conditions);
    }

    public function deleteMeal($mealId) {
        $conditions = "id = $mealId";
        return $this->destroy($conditions);
    }
}
