<?php

use App\Models\Permission;
use Core\Http\Request;
use App\Models\Position;
use App\Models\Room;


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
