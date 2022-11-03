<?php

use Core\Http\Request;
use App\Models\Position;

if (!function_exists('checkAdmin')) {
     function checkAdmin() {
          $obj_request = new Request;
          $admin_ary = $obj_request->getUser();
          if ($admin_ary !== null && $admin_ary['role_id'] == 1) {
               return TRUE;
          } else {
               return FALSE;
          } 
     }
}

if (!function_exists('isLogged')) {
     function isLogged() {
          $obj_request = new Request;
          $admin_ary = $obj_request->getUser();
          // var_dump($admin_ary);
          // exit;
          if (isset($admin_ary)) {
               return TRUE;
          } else {
               return FALSE;
          } 
     }
}

if (!function_exists('checkAccess')) {
     function checkAccess($controller) {
          $obj_request = new Request;
          $user_position = $obj_request->getUser()['position_id'];

          $access_page =  Position::getColAccessById($user_position)['access_page'];
          $access_page = explode(',', $access_page);

          if (in_array($controller, $access_page)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('setDefineArray')) {
     function setDefineArray($name, $ary) {
          if ($name == "") return;
          global $$name;
          if (isset($$name)) return;
          $temp = array();
          foreach ($ary as $key => $value) {
               $temp[$key] = $value;
          }
          $$name = $temp;
          return $$name;
     }
}

if (!function_exists('setTempGlobal')) {
     function setTempGlobal($variableGLOBALS, $globalsVarName, $tempGlobal) {
          if (!empty($variableGLOBALS)) {
               foreach($variableGLOBALS as $each){
                    $globalsVarName[] = $each;
                    $tempGlobal[$each] = $GLOBALS[$each];
                    unset($GLOBALS[$each]);
               }
          }
          return array($globalsVarName, $tempGlobal);
     }
}
