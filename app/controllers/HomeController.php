<?php

namespace App\Controllers;

use App\models\Meal;
use Core\View;
use Core\Http\Request;

class HomeController extends AppController {
    public $title = 'Home';

    public array $data_ary;

    public function indexAction() {
        $meal = new Meal();
        $result_ary = $meal->getAllOpenMeals();
        $this->data_ary['open_meals'] = $result_ary;
        $this->data_ary['content'] = '/home/homepage';
    }
}
