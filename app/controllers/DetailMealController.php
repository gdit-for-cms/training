<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\Models\Meal;
use Core\Http\Request;

class DetailMealController extends AppController {
    public array $data_ary;

    function displayGeneralDetailAction(Request $request) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['link'])) {
            }
        }
        $detail_meal = new DetailMeal;
        $meal = new Meal;
        $this->data_ary['meals'] = $meal->getMealsByUser();
        $meal_id = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['meal_id'])) {
                $meal_id = $_POST['meal_id'];
            }
        } else {
            $meal_id = $this->data_ary['meals'][0]['id'];
        }
        $this->data_ary['detail_meals'] = $detail_meal->getGenerallDetailMealByMealId($meal_id);
        $this->data_ary['content'] = '/meal/manager_meal';
    }
}
