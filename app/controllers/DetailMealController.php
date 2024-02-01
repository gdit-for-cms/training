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
        if (isset($_GET['meal_id']) && $_GET['meal_id'] != 0) {
            $meal_id = $_GET['meal_id'];
            foreach ($this->data_ary['meals'] as $element) {
                if ($element['id'] == $meal_id) {
                    $this->data_ary['status'] = $element['closed'];
                    $this->data_ary['store_id'] = $element['store_id'];
                    $this->data_ary['store_name'] = $element['store_name'];
                    break;
                }
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
        $this->data_ary['title'] = 'Quản lí đơn';
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
