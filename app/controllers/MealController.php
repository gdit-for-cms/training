<?php

namespace App\Controllers;

use App\Models\Meal;
use Core\View;
use Core\Http\Request;

class MealController extends AppController {

    public array $data_ary;

    public function createAction() {
        $this->data_ary['title'] = 'Tạo đơn';
        $this->data_ary['content'] = '/meal/create';
    }

    public function displayOpenMealsAction() {
    }

    public function createMealAction(Request $request) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['link'])) {
                $url = $_POST['link'];
                $order_name = "";
                if (isset($_POST['name'])) {
                    $order_name = $_POST['name'];
                }
                $meal = new Meal();
                $meal->create($url, $order_name);
            } else {
            }
        } else {
            echo "Không có dữ liệu được gửi qua phương thức POST";
        }
        echo "ok";

        header('Location: /home/index');
        exit;
    }
}
