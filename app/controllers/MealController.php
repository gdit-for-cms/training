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
}
