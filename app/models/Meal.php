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

    public function create($url, $is_free) {
        $store = new Store();
        $store_id = $store->checkLink($url);
        if ($store_id === -1) {
            return FALSE;
        }
        $request = new Request;

        $user = $request->getUser();

        if ($this->createMeal($user['id'], $store_id, $is_free)) {
            return TRUE;
        }
        return FALSE;
    }

    public function createMeal($user_id, $store_id, $is_free = FALSE) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO meal (user_id, store_id, time_open, is_free, closed) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $currentDateTime = new DateTime();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $store_id);
        $stmt->bindParam(3, $currentDateTimeString);
        $stmt->bindParam(4, $is_free, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function closeMeal($meal_id) {
        $pdo = parent::getDB();
        $sql = "UPDATE meal SET closed = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        return $result;
    }

    public function openMeal($meal_id) {
        $pdo = parent::getDB();
        $sql = "UPDATE meal SET closed = 0 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        return $result;
    }

    public function getDetailMealById($mealId, $status = null) {
        $query = $this->table($this->_table)
            ->join('app_user', 'meal.user_id = app_user.id')
            ->join('store', 'meal.store_id = store.id')
            ->where('meal.id', '=', $mealId);

        if ($status !== null) {
            $query->where('meal.closed', '=', $status);
        }

        $selectColumns = 'meal.*, '
            . 'app_user.name as user_name, app_user.display_name, app_user.img_code, '
            . 'store.name as store_name, store.link, store.update_date, store.image';


        return $query->select($selectColumns)->get();
    }

    public function getAllOpenMeals() {
        $this->table($this->_table)
            ->join('app_user', 'meal.user_id = app_user.id')
            ->join('store', 'meal.store_id = store.id')
            ->where('meal.closed', '=', 0)
            ->orderBy('time_open', 'desc');

        $selectColumns = 'meal.id, meal.user_id, meal.store_id, meal.time_open as time_open, meal.closed, meal.is_free, '
            . 'app_user.name as user_meal_name, app_user.display_name as user_meal_display_name, app_user.img_code as user_meal_code, '
            . 'store.name as store_meal_name, store.link as store_meal_link, store.update_date, store.image as store_meal_img';

        return $this->select($selectColumns)->get();
    }

    public function getMealsByUser() {
        $request = new Request;
        $user_id = $request->getUser()['id'];
        $meals = array();
        $pdo = parent::getDB();
        $sql = "SELECT m.id as id, m.store_id as store_id, m.time_open as time_open, 
        m.closed as closed, m.is_free, s.name as store_name, s.image as image
        FROM meal m 
        JOIN store s on m.store_id = s.id
        WHERE m.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $meal = array(
                'id' => $row['id'],
                'store_id' => $row['store_id'],
                'time_open' => $row['time_open'],
                'closed' => $row['closed'],
                'store_name' => $row['store_name'],
                'image' => $row['image'],
                'is_free' => $row['is_free']
            );
            $meals[] = $meal;
        }
        return $meals;
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

    public function getStoreFromMealId($mealId) {
        $this->table($this->_table)
            ->join('store', 'meal.store_id = store.id')
            ->where('meal.id', '=', $mealId);

        $selectColumns = 'store.id, store.name, store.link, store.update_date, store.image, store.deleted';

        return $this->select($selectColumns)->first();
    }

    public function checkMealClosed($meal_id) {
        $pdo = parent::getDB();
        $sql = "SELECT closed FROM meal WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $meal_id);
        $result = $stmt->execute();
        return $result;
    }
}
