<?php

function showSuccess($successName) {
    $error_ary = [
        "createMeal" => 'Tạo hóa đơn thành công'
    ];
    if ($error_ary[$successName]) {
        return $error_ary[$successName];
    } else {
        return  $error_ary['undefined_error'];
    }
}
