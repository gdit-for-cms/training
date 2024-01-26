<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;
use Core\Http\Request;

class DetailMeal extends Model {
    use QueryBuilder;

    private $_table = 'detail_meal';

    public function createMealDetail($userId, $mealId, $foodId, $price, $description, $amount) {
        $data = [
            'user_id' => $userId,
            'meal_id' => $mealId,
            'food_id' => $foodId,
            'price' => $price,
            'describes' => $description,
            'amount' => $amount
        ];

        return $this->insert($data);
    }

    public function getDetailsByUserAndMeal($mealId, $userId) {
        $this->table('detail_meal')
            ->join('meal', 'detail_meal.meal_id = meal.id')
            ->join('app_user', 'meal.user_id = app_user.id')
            ->join('food', 'detail_meal.food_id = food.id')
            ->where('meal.id', '=', $mealId)
            ->where('meal.user_id', '=', $userId);

        $selectColumns = 'detail_meal.*, '
            . 'meal.time_open, meal.closed, '
            . 'app_user.name as user_name, app_user.display_name, app_user.img_code, '
            . 'food.name as food_name, food.price, food.image';

        return $this->select($selectColumns)->get();
    }
    public function updateMealDetail($mealDetailId, $data) {
        $conditions = "id = $mealDetailId";
        return $this->update($data, $conditions);
    }

    public function deleteMealDetail($mealDetailId) {
        $conditions = "id = $mealDetailId";
        return $this->destroy($conditions);
    }
}
