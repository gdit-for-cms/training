<?php

function showError($errorName)
{
    $errorArray = [
        "login" => 'Email or Password is incorrect',
        "noWhitespace" => '"foo # bar" must not contain whitespace',
        "length" => null,
        "undefindError" => "Error undefind"
    ];
    if ($errorArray[$errorName]) {
        return $errorArray[$errorName];
    } else {
        return  $errorArray['undefindError'];
    }

}

?>