<?php

function showSuccess($successName) {
    $error_ary = [
        "createMeal" => 'Tạo đơn rồi nha, cảm ơn vì đã chờ ^^!',
        "createOrder" => 'Đơn đã được lưu lại rồi nha',
        "deleteMeal" => 'Đơn đã xóa rồi nha'
    ];
    if ($error_ary[$successName]) {
        return $error_ary[$successName];
    } else {
        return  $error_ary['undefined_error'];
    }
}
