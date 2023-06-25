<?php

use App\Models\Permission;
use Core\Http\Request;
use App\Models\Position;
use App\Models\Room;

if (!function_exists('checkAuth')) {
     function checkAuth() {
          $obj_request = new Request;
          $admin_ary   = $obj_request->getUser();
          if ($admin_ary !== null && (in_array($admin_ary['role_id'], [1, 2, 3]))) {

               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('isLogged')) {
     function isLogged() {
          $obj_request = new Request;
          $admin_ary   = $obj_request->getUser();
          if (isset($admin_ary)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('checkAccess')) {
     function checkAccess($controller) {
          $obj_request   = new Request;
          $user_position = $obj_request->getUser()['position_id'];

          $access_page = Position::getColAccessById($user_position)['access_page'];
          $access_page = explode(',', $access_page);
          if (in_array($controller, $access_page)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('checkPermission')) {
     function checkPermission() {
          if (getLevel() == 1) {
               return TRUE;
          } else {
               $obj_request = new Request;
               $req_url     = $obj_request->getUrl();
               $url_ary     = explode('/', $req_url);
               unset($url_ary[0]);
               $user_room              = $obj_request->getUser()['room_id'];
               $permissions_access_ary = Room::getPermissionsAccess($user_room);
               if (count($url_ary) == 3) {
                    $controller = $url_ary[2];
                    if (in_array($controller, ['user', 'room', 'position'])) {
                         return FALSE;
                    } else {
                         $check_access = false;
                         foreach ($permissions_access_ary as $permission) {
                              if ($controller == $permission['controller']) {
                                   $check_access = true;
                                   break;
                              }
                         }
                         if ($check_access) {
                              if (getLevel() == 2) {
                                   return TRUE;
                              } else {
                                   $url_ary[3] = explode('?', $url_ary[3])[0];
                                   if (in_array($url_ary[3], ['index', 'list', 'rulesDetail', 'show'])) {
                                        return TRUE;
                                   }
                                   return FALSE;
                              }
                         }
                         return FALSE;
                    }
               }
               return TRUE;
          }
     }
}
if (!function_exists('getLevel')) {
     function getLevel() {
          $obj_request = new Request;
          $admin_ary   = $obj_request->getUser();
          if ($admin_ary !== null) {
               return $admin_ary['role_id'];
          }
     }
}

if (!function_exists('checkRoomManager')) {
     function checkRoomManager() {
          $obj_request = new Request;
          $user_ary    = $obj_request->getUser();
          if ($user_ary !== null && ($user_ary['position_id'] == 1)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}


if (!function_exists('setDefineArray')) {
     function setDefineArray($name, $ary) {
          if ($name == "")
               return;
          global $$name;
          if (isset($$name))
               return;
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
               foreach ($variableGLOBALS as $each) {
                    $globalsVarName[]  = $each;
                    $tempGlobal[$each] = $GLOBALS[$each];
                    unset($GLOBALS[$each]);
               }
          }
          return array($globalsVarName, $tempGlobal);
     }
}