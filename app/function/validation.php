<?php
if (!function_exists('string')) {
    function string($value)
    {
        return is_string(($value));
    }
}

if (!function_exists('required')) {
    function required()
    {
        return true;
    }
}

if (!function_exists('filled')) {
    function filled($value)
    {
        if ($value != '') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('maxLen')) {
    function maxLen($length, $value)
    {
        if (strlen($value) <= $length) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('minLen')) {
    function minLen($length, $value)
    {
        if (strlen($value) >= $length) {
            return true;
        } else {
            return false;
        }
    }
}
