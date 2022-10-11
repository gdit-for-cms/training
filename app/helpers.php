<?php

use Core\Http\Request;

if (! function_exists('checkAdmin')) {
     function checkAdmin() {
          $request = new Request;
          $admin = $request->getUser();
          if ($admin !== null && $admin['role_id'] == 1) {
               return true;
          } else {
               return false;
          } 
     }
}

if (! function_exists('setDefineArray')) {
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

if (! function_exists('setTempGlobal')) {
     function setTempGlobal($variableGLOBALS, $globalsVarName, $tempGlobal){
          if (!empty($variableGLOBALS)) {
               foreach($variableGLOBALS as $each){
                    $globalsVarName[] = $each;
                    $tempGlobal[$each] = $GLOBALS[$each];
                    unset($GLOBALS[$each]);
               }
          }
     
     return array( $globalsVarName, $tempGlobal );
     }
}