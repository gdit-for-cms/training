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
                $meal = new Meal();
                if ($meal->create($url)) {
                    $this->data_ary['success'] = showSuccess('createMeal');
                    header('Location: /home/index');
                    exit;
                }
            }
        }
        $this->data_ary['error'] = showError('loadHTML');
        header('Location: /home/index');
        exit;
    }
}
