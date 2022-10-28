<?php

function showError($errorName)
{
    $errorArray = [
        "login" => 'Email or Password is incorrect',
        "create" => 'Create failed',
        "existed" => 'Object has been exist',
        "email existed" => 'Email has been exist',
        "undefinedError" => "Error undefined",
    ];
    if ($errorArray[$errorName]) {
        return $errorArray[$errorName];
    } else {
        return  $errorArray['undefinedError'];
    }
}
