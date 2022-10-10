<?php

use Core\Http\Request;

function checkUser(){
     $request = new Request;
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