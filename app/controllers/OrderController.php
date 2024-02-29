<?php

namespace App\Controllers;

use App\Models\DetailOrder;
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
        $is_free = intval($_POST['is_free']);

        if (isset($_POST['ship_fee']) && !empty($_POST['ship_fee'])) {
            $ship_fee = $_POST['ship_fee'];
        }

        if (isset($_POST['discount']) && !empty($_POST['discount'])) {
            $discount = $_POST['discount'];
        }
        $user = $request->getUser();
        $user_id = $user['id'];
        $order->submitOrder($meal_id, $user_id, $store_id, $ship_fee, $discount, $is_free);
        $this->data_ary['success'] = showSuccess('createOrder');
        header('Location: /home/index');
        exit;
    }

    public function displayAction(Request $request) {
        $user = $request->getUser();
        $user_id = $user['id'];
        $detail_order = new DetailOrder;
        $list_for_debtor_unpaid = $detail_order->getUnconfirmedDebtListForDebtor($user_id, 0);
        $list_for_debtor_paid = $detail_order->getUnconfirmedDebtListForDebtor($user_id, 1);
        $list_for_creditor_unpaid = $detail_order->getUnconfirmedDebtListForCreditor($user_id, 0);
        $list_for_creditor_paid = $detail_order->getUnconfirmedDebtListForCreditor($user_id, 1);
        $list_detail = $detail_order->getAllDetailOrderRelatedToUser($user_id);
        $this->data_ary['list_for_debtor_unpaid'] = $list_for_debtor_unpaid;
        $this->data_ary['list_for_debtor_paid'] = $list_for_debtor_paid;
        $this->data_ary['list_for_creditor_unpaid'] = $list_for_creditor_unpaid;
        $this->data_ary['list_for_creditor_paid'] = $list_for_creditor_paid;
        $this->data_ary['list_detail'] = $list_detail;
        $this->data_ary['title'] = "Nợ nần";
        $this->data_ary['content'] = "/order/display";
    }

    public function payAction(Request $request) {
        if (isset($_GET['ids'])) {
            $list_id = explode(",", $_GET['ids']);
            $detail_order = new DetailOrder;
            $detail_order->updateDetailOrderPaid($list_id);
        }

        header('Location: /order/display');
    }

    public function confirmAction(Request $request) {
        if (isset($_GET['ids'])) {
            $list_id = explode(",", $_GET['ids']);
            $detail_order = new DetailOrder;
            $detail_order->updateDetailOrderConfirmed($list_id);
        }

        header('Location: /order/display');
    }

    public function displayHistoryAction(Request $request) {
        $user = $request->getUser();
        $user_id = $user['id'];
        $detail_order = new DetailOrder;
        $history_order_result = $detail_order->getHistoryOrderOfCurrentUser($user_id);

        if (!$history_order_result) {
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/home/index';
            if (strpos($referer, '/order/display-history')) {
                header('Location: /home/index');
                exit;
            } else {
                $_SESSION['non_history_order'] = TRUE;
                header('Location: ' . $referer);
                exit;
            }
        }

        $this->data_ary['history_order_of_current_user'] =  $history_order_result;
        $this->data_ary['title'] = "Lịch sử đặt";
        $this->data_ary['content'] = "/order/display_history";
    }
}
