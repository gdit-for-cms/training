<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\Models\Meal;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class DetailMealController extends AppController {
    use ResponseTrait;

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

    public function addOrderAction() {
        $json = file_get_contents('php://input');
        $orderData = json_decode($json, true);

        $detailMeal = new DetailMeal();

        try {
            $result = $detailMeal->processOrder($orderData);
            header('Content-Type: application/json');
            return $this->successResponse($result, 'Had response');
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            return $this->errorResponse($e->getMessage());
            exit;
        }
    }

    protected function after() {
    }
}
