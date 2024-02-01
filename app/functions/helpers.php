<?php

use Core\Http\Request;


if (!function_exists('isLogged')) {
    function isLogged() {
        $obj_request = new Request;
        $user = $obj_request->getUser();
        if (isset($user)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('isRegisterURL')) {
    function isRegisterURL() {
        $obj_request = new Request;
        $url = $obj_request->getURL();
        if ($url == 'register/register') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
