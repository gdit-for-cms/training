<?php

    function string($value)
    {
        // echo '123';
        // exit;
        return is_string(($value));
    }
    function required($value)
    {   
        return true;
    }
    function filled($value)
    {   
        if ($value != '') {
            return true;
        } else {
            return false;
        }
    }

    function maxLen($length, $value)
    {
        if (strlen($value) <= $length) {
            return true;
        } else {
            return false;
        }
    }

    function minLen($length, $value)
    {
        if (strlen($value) >= $length) {
            return true;
        } else {
            return false;
        }
    }

?>