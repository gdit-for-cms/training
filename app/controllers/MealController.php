<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\Models\Food;
use App\Models\Meal;
use App\Models\Store;
use Core\View;
use Core\Http\Request;

class MealController extends AppController {

    public array $data_ary;

    public function createAction() {
        $store = new Store();
        $result_ary = $store->getAllStores();
        $this->data_ary['stores'] = $result_ary;
        $this->data_ary['title'] = 'Tạo đơn';
        $this->data_ary['content'] = '/meal/create';
    }

    public function displayOpenMealsAction() {
    }

    public function createMealAction(Request $request) {
        $post = $request->getPost();
        $url = $post->get('link');

        $url = trim($url);

        if (isset($url)) {

            $is_free = isset($_POST['is_free']) ? TRUE : FALSE;

            $meal = new Meal();
            if ($meal->create($url, $is_free)) {
                $_SESSION['status_create_meal'] = TRUE;
                header('Location: /home/index');
                exit;
            } else {
                $_SESSION['status_create_meal'] = FALSE;
                header('Location: /home/index');
                exit;
            }
        }
    }

    public function showAction(Request $request) {
        $login_user = $request->getUser();
        $login_user_id = $login_user['id'];

        $encrypted = $request->getGet()->get('data');

        // Decode the base64 encoded string
        $encrypted = base64_decode($encrypted);

        // Split the encrypted data and the IV
        list($encryptedData, $iv) = explode('::', $encrypted, 2);

        // Decrypt the data
        $decrypted = openssl_decrypt($encryptedData, 'aes-256-cbc', 'gdit', 0, $iv);

        parse_str($decrypted, $output);

        $meal_id = $output['id'];

        $meal = new Meal();
        $detail_meal = $meal->getDetailMealById($meal_id, 0);
        if (!isset($detail_meal)) {
            // Handle error
            exit;
        }

        $object_detail_meal = new DetailMeal();
        $user_foods = $object_detail_meal->getDetailsByUserAndMeal($meal_id, $login_user_id);

        $store = $meal->getStoreFromMealId($meal_id);
        $store_id = $store['store_id'];
        $food = new Food();
        $foods = $food->getFoodsByStoreId($store_id);

        $this->data_ary['user_foods'] = $user_foods;
        $this->data_ary['meal_id'] = $meal_id;
        $this->data_ary['user_id'] = $login_user_id;
        $this->data_ary['detail_meal'] = $detail_meal;
        $this->data_ary['foods'] = $foods;
        $this->data_ary['title'] = 'Đặt món';
        $this->data_ary['content'] = '/detail_meal/list';
    }

    public function closeMealAction() {
        $id = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['meal_id'])) {
                $id = $_POST['meal_id'];
                $meal = new Meal;
                $meal->closeMeal($id);
            }
        }
        header('Location: /detail-meal/display-general-detail?meal_id=' . $id);
        exit;
    }

    public function openMealAction() {
        $id = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['meal_id'])) {
                $id = $_POST['meal_id'];
                $meal = new Meal;
                $meal->openMeal($id);
            }
        }
        header('Location: /detail-meal/display-general-detail?meal_id=' . $id);
        exit;
    }

    public function deleteMealAction() {
        if (!isset($_POST['meal_id'])) {
            echo "???";
            exit;
        }
        $meal_id = $_POST['meal_id'];

        $detail_meal = new DetailMeal;
        $meal = new Meal;
        $detail_meal->deleteAllDetailMealByMealId($meal_id);
        $meal->deleteMeal($meal_id);
        header('Location: /detail-meal/display-general-detail');
        exit;
    }
}
