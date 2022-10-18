<?php

namespace App;
use Core\Http\Request;

class Validation {

    public function string($value)
    {
        return is_string(($value));
    }
}
?>