<?php
if (!function_exists('name')) {
    function name($value)
    {
        $valueArray = explode(' ', $value);
        foreach ($valueArray as $key => $valueKey) {
            if ($valueKey == '') {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('email')) {
    function email($value)
    {
        $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
        if (preg_match($pattern, $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('password')) {
    function password($value)
    {
        $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
        if (preg_match($pattern, $value) || $value == '') {
            return true;
        } else {
            return false;
        }
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
