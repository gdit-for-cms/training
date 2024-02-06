<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\models\Meal;
use Core\View;
use Core\Http\Request;

class HomeController extends AppController {
    public $title = 'Home';

    public array $data_ary;

    public function indexAction(Request $request) {
        $login_user = $request->getUser();
        $login_user_id = $login_user['id'];

        $obj_detail_meal = new DetailMeal();
        $meals_by_login_user = $obj_detail_meal->getMealsByUser($login_user_id);

        $meal = new Meal();
        $all_meals = $meal->getAllOpenMeals();

        // Check and add status in meal that login user had ordered
        foreach ($all_meals as $index => $meal) {
            // Initialize has_ordered as false
            $all_meals[$index]['has_ordered'] = false;

            // Iterate over the mealIdArray to check if the meal's id exists
            foreach ($meals_by_login_user as $orderedMeal) {
                if ($meal['id'] === $orderedMeal['meal_id']) {
                    $all_meals[$index]['has_ordered'] = true;
                    break;
                }
            }
        }

        // If do not have meal
        if ($request->getGet()->has('non-meal')) {
            $non_meal_status = $request->getGet()->get('non-meal');
            $this->data_ary['non_meal_status'] = $non_meal_status;
        }
        $this->data_ary['open_meals'] = $all_meals;
        $this->data_ary['content'] = '/home/homepage';
    }
}
