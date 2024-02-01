<?php

namespace App\Controllers;

use App\models\Meal;
use Core\View;
use Core\Http\Request;

class HomeController extends AppController {
    public $title = 'Home';

    public array $data_ary;

    public function indexAction(Request $request) {
        $meal = new Meal();
        $result_ary = $meal->getAllOpenMeals();

        // If after update
        if ($request->getGet()->has('non-meal')) {
            $non_meal_status = $request->getGet()->get('non-meal');
            $this->data_ary['non_meal_status'] = $non_meal_status;
        }

        $this->data_ary['open_meals'] = $result_ary;
        $this->data_ary['content'] = '/home/homepage';
    }
}
