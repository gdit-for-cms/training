<?php

namespace App\Models;

use Core\Model;
use DOMDocument;
use PDO;


class Food extends Model {
    function createListFood($id, $name_list, $price_list, $img_list) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO food (name, price, store_id, image, deleted) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $count = count($name_list);
        $pdo->beginTransaction();
        for ($i = 0; $i < $count; $i++) {
            $name_food = $name_list[$i];
            $price_food = str_replace(',', '', $price_list[$i]);
            $image_food = $img_list[$i];
            $stmt->bindParam(1, $name_food);
            $stmt->bindParam(2, $price_food, PDO::PARAM_INT);
            $stmt->bindParam(3, $id, PDO::PARAM_INT);
            $stmt->bindParam(4, $image_food);
            $stmt->execute();
        }
        $pdo->commit();
    }

    function createFood($id, $name_food, $price_food, $image_food) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO food (name, price, store_id, image, deleted) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $name_food);
        $stmt->bindParam(2, $price_food, PDO::PARAM_INT);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $stmt->bindParam(4, $image_food);
        $result = $stmt->execute();
        return $result;
    }

    function updateFood($id, $price_food, $image_food) {
        $pdo = parent::getDB();
        $sql = "UPDATE food SET price = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $price_food, PDO::PARAM_INT);
        $stmt->bindParam(2, $image_food);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    function getFoodFromStore($id) {
        $pdo = parent::getDB();
        $list_food = array();
        $sql = "SELECT f.id, f.name, f.price, f.image FROM food f JOIN store s ON f.store_id = s.id WHERE s.id = :id AND f.deleted = 0";
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
}
