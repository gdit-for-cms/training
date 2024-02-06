<?php

namespace App\Models;

use Core\Model;
use DateTime;

class Order extends Model {
    public function createOrder($user_id, $store_id, $ship_fee, $discount) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO orders(user_id, store_id, time_close, ship_fee, discount, deleted)
        VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);

        $currentDateTime = new DateTime();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');

        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $store_id);
        $stmt->bindParam(3, $currentDateTimeString);
        $stmt->bindParam(4, $ship_fee);
        $stmt->bindParam(5, $discount);
        $stmt->execute();
        $lastInsertedId = $pdo->lastInsertId();
        return $lastInsertedId;
    }

    public function submitOrder($meal_id, $user_id, $store_id, $ship_fee, $discount, $is_free) {
        $order_id = $this->createOrder($user_id, $store_id, $ship_fee, $discount);
        $detail_meal = new DetailMeal;
        $detail_order = new DetailOrder;
        $meal = new Meal;
        $detail_meal_list = $detail_meal->getDetailMealByMealId($meal_id);
        $temporary_total_money = 0;
        foreach ($detail_meal_list as $detail) {
            $temporary_total_money += $detail['amount'] * $detail['price'];
        }
        $final_total_money = $temporary_total_money + $ship_fee - $discount;
        if ($is_free) {
            foreach ($detail_meal_list as $detail) {
                $price = $detail['price'] * $final_total_money / $temporary_total_money;
                $detail_order->createDetailOrder($detail['user_id'], $order_id, $detail['food_id'], $price, $detail['amount'], $detail['describes'], 1, 1);
            }
        } else {
            foreach ($detail_meal_list as $detail) {
                $price = $detail['price'] * $final_total_money / $temporary_total_money;
                if ($user_id === $detail['user_id']) {
                    $detail_order->createDetailOrder($detail['user_id'], $order_id, $detail['food_id'], $price, $detail['amount'], $detail['describes'], 1, 1);
                } else {
                    $detail_order->createDetailOrder($detail['user_id'], $order_id, $detail['food_id'], $price, $detail['amount'], $detail['describes']);
                }
            }
        }


        $detail_meal->deleteAllDetailMealByMealId($meal_id);
        $meal->deleteMeal($meal_id);
    }
}
