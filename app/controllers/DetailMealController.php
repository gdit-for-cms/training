<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\Models\Meal;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use Core\View;

class DetailMealController extends AppController {
    use ResponseTrait;

    public array $data_ary;

    function displayGeneralDetailAction(Request $request) {
        $detail_meal = new DetailMeal;
        $meal = new Meal;
        $this->data_ary['meals'] = $meal->getMealsByUser();
        if (!$this->data_ary['meals']) {
            $this->data_ary['errors'] = showError('nonMeal');
            header('Location: /home/index');
            exit;
        }
        $meal_id = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['meal_id']) && isset($_POST['closed']) && isset($_POST['store_id'])  && isset($_POST['store_name'])) {
                $meal_id = $_POST['meal_id'];
                $this->data_ary['status'] = $_POST['closed'];
                $this->data_ary['store_id'] = $_POST['store_id'];
                $this->data_ary['store_name'] = $_POST['store_name'];
            }
        } else {
            $meal_id = $this->data_ary['meals'][0]['id'];
            $this->data_ary['status'] = $this->data_ary['meals'][0]['closed'];
            $this->data_ary['store_id'] = $this->data_ary['meals'][0]['store_id'];
            $this->data_ary['store_name'] = $this->data_ary['meals'][0]['store_name'];
        }
        $this->data_ary['meal_id'] = $meal_id;
        $this->data_ary['detail_meals'] = $detail_meal->getGeneralDetailMealByMealId($meal_id);
        $this->data_ary['content'] = '/meal/manager_meal';
        View::render('/layouts/master.php', $this->data_ary);
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
