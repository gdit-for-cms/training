<?php

use Core\Http\Request;

if (!function_exists('checkAdmin')) {
     function checkAdmin() {
          $request = new Request;
          $admin = $request->getUser();
          if ($admin !== null && $admin['role_id'] == 1) {
               return TRUE;
          } else {
               return FALSE;
          } 
     }
}

if (!function_exists('setKeyValueAry')) {
     function setKeyValueAry($arr) {
        static $temp = array();
        $arr = explode('=>', rtrim(trim($arr), ','));
        $key = trim($arr[0]);
        $value = trim($arr[1]);
        $temp[trim($key, "'")] = trim($value, "'");

        return $temp;
     }
}
