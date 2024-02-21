<?php

function showError($errorName) {
    $error_ary = [
        "login name" => 'Tên đăng nhập không tồn tại',
        "login password" => 'Mật khẩu không đúng',
        "create" => 'Create failed',
        "existed" => 'Object has been exist',
        "name existed" => 'name existed',
        "display name existed" => 'display name existed',
        "both name existed" => 'both name existed',
        "none register value" => 'none register value',
        "undefined_error" => "Error undefined",
        "string" => "This field must be string",
        "required" => "Missing a field",
        "filled" => "Please fil out this field",
        "maxLen" => "The entered text too long",
        "minLen" => "The entered text too short",
        "email" => "The entered text must be email format",
        "name" => "The entered text must be name format",
        "gender" => "'gender' you selected does not exist",
        "password" => "The entered text must be password format",
        "pageExisted" => "'page' you selected does not exist",
        "loadHTML" => 'Can not load HTML from your page, please check link and try again',
        "nonMeal" => 'Bạn không có đơn nào để quản lí',
        "email existed" => 'email existed'
    ];
    if ($error_ary[$errorName]) {
        return $error_ary[$errorName];
    } else {
        return  $error_ary['undefined_error'];
    }
}
