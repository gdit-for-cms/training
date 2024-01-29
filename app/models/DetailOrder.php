<?php

namespace App\Models;

use Core\Model;

class DetailOrder extends Model {
    public function createDetailOrder($user_id, $order_id, $food_id, $price, $amount, $describes) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO detail_order(user_id, order_id, food_id, price, amount, describes, payed, confirmed)
        VALUES (?, ?, ?, ?, ?, ?, 0, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $order_id);
        $stmt->bindParam(3, $food_id);
        $stmt->bindParam(4, $price);
        $stmt->bindParam(5, $amount);
        $stmt->bindParam(6, $describes);
        $result = $stmt->execute();
        return $result;
    }
}
