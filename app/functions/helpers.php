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
