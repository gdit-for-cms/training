<?php
if (!function_exists('name')) {
    function name($value) {
        $value_ary = explode(' ', $value);
        foreach ($value_ary as $key => $value_key) {
            if ($value_key == '') {
                return FALSE;
            }
        }
        return TRUE;
    }
}

if (!function_exists('pass')) {
    function pass($value) {
        $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
        if (preg_match($pattern, $value) || $value == '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('display_name')) {
    function display_name($value) {
        $value_ary = explode(' ', $value);
        foreach ($value_ary as $key => $value_key) {
            if ($value_key == '') {
                return FALSE;
            }
        }
        return TRUE;
    }
}

if (!function_exists('required')) {
    function required() {
        return TRUE;
    }
}

if (!function_exists('filled')) {
    function filled($value) {
        if ($value != '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('maxLen')) {
    function maxLen($length, $value) {
        if (strlen($value) <= $length) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('minLen')) {
    function minLen($length, $value) {
        if (strlen($value) >= $length) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('pageExisted')) {
    function pageExisted($value) {
        $controller_ary = array_diff(scandir('../app/controllers/User'), array('..', '.'));
        $result_ary = array();
        foreach ($controller_ary as $filename) {
            array_push($result_ary, strtolower((preg_split('/(?=[A-Z])/', $filename)[1])));
        }
        $result_ary = array_diff($value, $result_ary);

        if (empty($result_ary)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
