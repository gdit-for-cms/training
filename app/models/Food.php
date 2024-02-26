<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use PDO;


class Food extends Model {

    use QueryBuilder;

    private $_table = 'food';

    function createListFood($id, $name_list, $price_list, $img_list, $status_list) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO food (name, price, store_id, image, deleted, is_over) VALUES (?, ?, ?, ?, 0, ?)";
        $stmt = $pdo->prepare($sql);
        $count = count($name_list);
        $pdo->beginTransaction();
        for ($i = 0; $i < $count; $i++) {
            $name_food = $name_list[$i];
            $price_food = str_replace(',', '', $price_list[$i]);
            $image_food = $img_list[$i];
            $is_over = $status_list[$i];
            $stmt->bindParam(1, $name_food);
            $stmt->bindParam(2, $price_food, PDO::PARAM_INT);
            $stmt->bindParam(3, $id, PDO::PARAM_INT);
            $stmt->bindParam(4, $image_food);
            $stmt->bindParam(5, $is_over, PDO::PARAM_INT);
            $stmt->execute();
        }
        $pdo->commit();
    }

    function createFood($id, $name_food, $price_food, $image_food, $is_over = 0) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO food (name, price, store_id, image, deleted, is_over) VALUES (?, ?, ?, ?, 0, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $name_food);
        $stmt->bindParam(2, $price_food, PDO::PARAM_INT);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $stmt->bindParam(4, $image_food);
        $stmt->bindParam(5, $is_over, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    function updateFood($id, $price_food, $image_food, $is_over = 0) {
        $pdo = parent::getDB();
        $sql = "UPDATE food SET price = ?, image = ?, is_over = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $price_food, PDO::PARAM_INT);
        $stmt->bindParam(2, $image_food);
        $stmt->bindParam(3, $is_over, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    function getFoodFromStore($id) {
        $pdo = parent::getDB();
        $list_food = array();
        $sql = "SELECT f.id, f.name, f.price, f.image, f.is_over FROM food f JOIN store s ON f.store_id = s.id WHERE s.id = :id AND f.deleted = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        while ($food = $stmt->fetchObject()) {
            array_push($list_food, $food);
        }

        return $list_food;
    }

    function deleteFood($id) {
        $pdo = parent::getDB();
        $sql = "UPDATE food SET deleted = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Query Builder

    public function updateFoodQB($foodId, $data) {
        $conditions = "id = $foodId";
        return $this->update($data, $conditions);
    }

    public function getFoodById($foodId) {
        return $this->where('id', ' = ', $foodId)
            ->where('deleted', ' = ', 0) // Only get if not marked as deleted
            ->first();
    }

    public function getAllFoods() {
        return $this->where('deleted', '=', 0) // Only get foods not marked as deleted
            ->all();
    }

    public function deleteFoodQB($foodId) {
        // Soft delete the food item by setting 'deleted' to 1
        $data = ['deleted' => 1];
        $conditions = "id = $foodId";
        return $this->update($data, $conditions);
    }

    public function getFoodsByStoreId($storeId) {
        return $this->table($this->_table) // Assuming 'foods' is your table name
            ->where('store_id', '=', $storeId)
            ->where('deleted', '=', 0)
            ->where('is_over', ' = ', 0) // Only get available foods
            ->get();
    }
}
