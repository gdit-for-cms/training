<?php

namespace App\Controllers;

use App\Models\Order;
use Core\Http\Request;

class OrderController extends AppController {

    public array $data_ary;

    function createOrderAction(Request $request) {
        $order = new Order;
        $discount = 0;
        $ship_fee = 0;
        if (!isset($_POST['meal_id']) || !isset($_POST['store_id'])) {
            echo "nothing";
            exit;
        }

        $meal_id = $_POST['meal_id'];
        $store_id = $_POST['store_id'];

        if (isset($_POST['ship_fee']) && !empty($_POST['ship_fee'])) {
            $ship_fee = $_POST['ship_fee'];
        }

        if (isset($_POST['discount']) && !empty($_POST['discount'])) {
            $discount = $_POST['discount'];
        }
        $user = $request->getUser();
        $user_id = $user['id'];
        $order->submitOrder($meal_id, $user_id, $store_id, $ship_fee, $discount);
        $this->data_ary['success'] = showSuccess('createOrder');
        header('Location: /home/index');
        exit;
    }

    public function displayAction(Request $request) {
        $this->data_ary['content'] = "/order/display";
    }
}
