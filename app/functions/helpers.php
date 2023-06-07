<?php

use App\Models\Permission;
use Core\Http\Request;
use App\Models\Position;
use App\Models\Room;

if (!function_exists('checkAuth')) {
     function checkAuth()
     {
          $obj_request = new Request;
          $admin_ary = $obj_request->getUser();
          if ($admin_ary !== null && ($admin_ary['role_id'] == 1 || $admin_ary['role_id'] == 2 || $admin_ary['role_id'] == 3)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('isLogged')) {
     function isLogged()
     {
          $obj_request = new Request;
          $admin_ary = $obj_request->getUser();
          if (isset($admin_ary)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('checkAccess')) {
     function checkAccess($controller)
     {
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

if (!function_exists('checkPermission')) {
     function checkPermission()
     {
          if (!checkAdmin()) {
               if (!checkRoomManager()) {
                    $obj_request = new Request;
                    $req_url = $obj_request->getUrl();
                    $url_ary = explode('/', $req_url);
                    unset($url_ary[0]);
                    // /admin
                    if (count($url_ary) == 1) {
                         return TRUE;
                    }
                    // /admin/rule/create
                    if (count($url_ary) == 3) {
                         $url_ary[3] = explode('?', $url_ary[3])[0];
                         $controller_action = implode('/', $url_ary);
                         if (in_array($url_ary[2], ['user', 'room', 'position'])) {
                              return FALSE;
                         } else {
                              if (in_array($url_ary[3], ['index', 'list', 'rulesDetail'])) {
                                   return TRUE;
                              }
                              return FALSE;
                         }
                    }
               } else {
                    $obj_request = new Request;
                    $user_room = $obj_request->getUser()['room_id'];
                    $permissions_access_ary =  Room::getPermissionsAccess($user_room);
                    $req_url = $obj_request->getUrl();
                    $url_ary = explode('/', $req_url);
                    unset($url_ary[0]);
                    if (count($url_ary) == 3) {
                         $url_ary[3] = explode('?', $url_ary[3])[0];
                         $controller_action = implode('/', $url_ary);

                         foreach ($permissions_access_ary as $permission) {
                              if ($controller_action == $permission['controller_action']) {
                                   return TRUE;
                              }
                         }
                         return FALSE;
                    }
                    return TRUE;
               }
          } else {
               return TRUE;
          }
     }
}
if (!function_exists('checkAdmin')) {
     function checkAdmin()
     {
          $obj_request = new Request;
          $admin_ary = $obj_request->getUser();
          if ($admin_ary !== null && ($admin_ary['role_id'] == 1)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}

if (!function_exists('checkRoomManager')) {
     function checkRoomManager()
     {
          $obj_request = new Request;
          $user_ary = $obj_request->getUser();
          if ($user_ary !== null && ($user_ary['position_id'] == 1)) {
               return TRUE;
          } else {
               return FALSE;
          }
     }
}


if (!function_exists('setDefineArray')) {
     function setDefineArray($name, $ary)
     {
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
     function setTempGlobal($variableGLOBALS, $globalsVarName, $tempGlobal)
     {
          if (!empty($variableGLOBALS)) {
               foreach ($variableGLOBALS as $each) {
                    $globalsVarName[] = $each;
                    $tempGlobal[$each] = $GLOBALS[$each];
                    unset($GLOBALS[$each]);
               }
          }
          return array($globalsVarName, $tempGlobal);
     }
}
