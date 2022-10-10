<?php

use Core\Http\Request;

function checkUser(Request $request){
   if ($request->getUser() !== null) {
        return true;
   } else {
        return false;
   } 
}

function test(){
    return 1;
 }

?>