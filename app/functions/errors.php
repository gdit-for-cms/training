<?php

function showError($errorName) {
    $error_ary = [
        "login" => 'Email or Password is incorrect',
        "create" => 'Create failed',
        "existed" => 'Object has been exist',
        "email existed" => 'Email has been exist',
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
        "pageExisted" => "'page' you selected does not exist"
    ];
    if ($error_ary[$errorName]) {
        return $error_ary[$errorName];
    } else {
        return  $error_ary['undefined_error'];
    }
}
