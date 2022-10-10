<?php

use Core\Http\Request;

function checkUser() {
     $request = new Request;
     $user = $request->getUser();
     if ($user !== null && $user['role_id'] == 1) {
          return true;
     } else {
          return false;
     } 
}

function test(){
    return 1;
}
