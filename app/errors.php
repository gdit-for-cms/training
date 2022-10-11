<?php

function showError($errorName)
{
    $errorArray = [
        "login" => 'Email or Password is incorrect',
        "create" => 'Create failed',
        "undefindError" => "Error undefind",
    ];
    if ($errorArray[$errorName]) {
        return $errorArray[$errorName];
    } else {
        return  $errorArray['undefindError'];
    }

}

?>