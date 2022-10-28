<?php
if (!function_exists('name')) {
    function name($value)
    {
        $value_ary = explode(' ', $value);
        foreach ($value_ary as $key => $value_key) {
            if ($value_key == '') {
                return FALSE;
            }
        }
        return TRUE;
    }
}

if (!function_exists('email')) {
    function email($value)
    {
        $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
        if (preg_match($pattern, $value)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('password')) {
    function password($value)
    {
        $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
        if (preg_match($pattern, $value) || $value == '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('required')) {
    function required()
    {
        return TRUE;
    }
}

if (!function_exists('filled')) {
    function filled($value)
    {
        if ($value != '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('maxLen')) {
    function maxLen($length, $value)
    {
        if (strlen($value) <= $length) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('minLen')) {
    function minLen($length, $value)
    {
        if (strlen($value) >= $length) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
