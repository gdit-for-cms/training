<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use PDO;

class DetailOrder extends Model {
    use QueryBuilder;

    public function createDetailOrder($user_id, $order_id, $food_id, $price, $amount, $describes, $payed = 0, $confirmed = 0) {
        $pdo = parent::getDB();
        $sql = "INSERT INTO detail_order(user_id, order_id, food_id, price, amount, describes, payed, confirmed)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $order_id);
        $stmt->bindParam(3, $food_id);
        $stmt->bindParam(4, $price);
        $stmt->bindParam(5, $amount);
        $stmt->bindParam(6, $describes);
        $stmt->bindParam(7, $payed, PDO::PARAM_BOOL);
        $stmt->bindParam(8, $confirmed, PDO::PARAM_BOOL);
        $result = $stmt->execute();
        return $result;
    }

    public function getUnconfirmedDebtListForDebtor($user_id, $paid) {
        $pdo = parent::getDB();
        $sql = "SELECT a1.display_name AS debtor_name, a1.id as debtor_id, 
        a2.display_name as creditor_name, a2.id as creditor_id, SUM(d.amount*d.price) AS total,
        GROUP_CONCAT(d.id SEPARATOR',') AS ids,
        a2.bank_bin, a2.bank_acc  
        FROM detail_order d
        JOIN orders o ON d.order_id = o.id
        JOIN app_user a1 ON a1.id = d.user_id
        JOIN app_user a2 ON a2.id = o.user_id
        WHERE d.confirmed = 0 AND d.payed = ?
        AND d.user_id = ? 
        GROUP BY o.user_id
        ORDER BY o.user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $paid, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $user_id);
        $result = $stmt->execute();
        $results = [];
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public function getUnconfirmedDebtListForCreditor($user_id, $paid) {
        $pdo = parent::getDB();
        $sql = "SELECT a1.display_name AS debtor_name, a1.id as debtor_id, 
        a2.display_name as creditor_name, a2.id as creditor_id, SUM(d.amount*d.price) AS total, 
        GROUP_CONCAT(d.id SEPARATOR',') AS ids  
        FROM detail_order d
        JOIN orders o ON d.order_id = o.id
        JOIN app_user a1 ON a1.id = d.user_id
        JOIN app_user a2 ON a2.id = o.user_id
        WHERE d.confirmed = 0 AND d.payed = ?
        AND o.user_id = ?
        GROUP BY d.user_id
        ORDER BY d.user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $paid, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $user_id);
        $result = $stmt->execute();
        $results = [];
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public function updateDetailOrderPaid($list_detail_orders) {
        $pdo = parent::getDB();
        $sql = "UPDATE detail_order d SET d.payed = 1 WHERE d.id = ?";
        $stmt = $pdo->prepare($sql);
        $detail_order_id = 0;
        $stmt->bindParam(1, $detail_order_id);
        foreach ($list_detail_orders as $id) {
            $detail_order_id = intval($id);
            $stmt->execute();
        }
    }

    public function updateDetailOrderConfirmed($list_detail_orders) {
        $pdo = parent::getDB();
        $sql = "UPDATE detail_order d SET d.confirmed = 1 WHERE d.id = ?";
        $stmt = $pdo->prepare($sql);
        $detail_order_id = 0;
        $stmt->bindParam(1, $detail_order_id);
        foreach ($list_detail_orders as $id) {
            $detail_order_id = intval($id);
            $stmt->execute();
        }
    }

    public function getAllDetailOrderRelatedToUser($user_id) {
        $pdo = parent::getDB();
        $sql = "SELECT a1.display_name AS debtor_name, 
        a2.display_name as creditor_name, f.name, d.amount, d.price, o.time_close, d.payed
        FROM detail_order d
        JOIN orders o ON d.order_id = o.id
        JOIN app_user a1 ON a1.id = d.user_id
        JOIN app_user a2 ON a2.id = o.user_id
        JOIN food f ON f.id = d.food_id
        WHERE d.confirmed = 0 
        AND (o.user_id = ? OR d.user_id = ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $user_id);
        $result = $stmt->execute();
        $results = [];
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public function getHistoryOrderOfCurrentUser($user_id) {
        $pdo = parent::getDB();
        $query =
            'SELECT * FROM (
                SELECT o.id AS order_id, a.display_name as creater_name, s.name AS store_name, o.time_close AS time_close, SUM(d.amount * d.price) AS total_price
                FROM orders o 
                JOIN detail_order d ON d.order_id = o.id
                JOIN app_user a ON a.id = o.user_id
                JOIN store s ON s.id = o.store_id
                WHERE d.user_id = ?
                GROUP BY o.id
            UNION
                SELECT o.id AS order_id, a.display_name as creater_name, s.name AS store_name, o.time_close AS time_close, 0 AS total_price
                FROM orders o 
                JOIN app_user a ON a.id = o.user_id  
                JOIN store s ON s.id = o.store_id
                WHERE o.user_id = ?
            ) 
            AS combine
            GROUP BY order_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $user_id);
        $result = $stmt->execute();
        $results = [];
        if ($result) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }
}
