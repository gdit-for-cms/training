<?php

namespace App\Requests;

use Core\Http\Request;
use App\Validation;
use Core\Http\ResponseTrait;

class AppRequest extends Request
{   
    use ResponseTrait;

    public function validate($rules, $request, $method)
    {   
        $req_method_ary = array();
        if ($method == 'post') {
            $req_method_ary = $request->getPost()->all();
        } else {
            $get_ary = $request->getGet()->all();
            array_shift($get_ary);
            $req_method_ary = $get_ary;
        }

        if ($req_method_ary == []) {
            header('Location: /room/new');
            exit;
        }

        $rule_requires = array();
        foreach ($rules as $key_rule => $value) {
            if (in_array('required', $value)) {
                $rule_requires[$key_rule] = $value;
            }
        }

        $same = array_intersect(array_keys($rule_requires), array_keys($req_method_ary));

        if ($same) {
            $diff = array_diff(array_keys($rule_requires), $same);
            if ($diff) {
                $results_ary = array('error', $diff[array_key_first($diff)] => 'required');
                return $results_ary;
            } else {
                foreach ($req_method_ary as $key1 => $value1) {
                    foreach ($rules as $key2 => $value2) {
                        if ($key1 == $key2) {
                            foreach ($value2 as $each) {
                                if (strpos($each, ':') !== false) {
                                    $each_ary =  explode(':', $each);
                                    if (function_exists($each_ary[0]) && !call_user_func($each_ary[0], $each_ary[1], $value1)) {
                                        $results_ary = array('error', $key1 => $each_ary[0]);
                                        return $results_ary;
                                    }
                                } else {
                                    if (function_exists($each) && !call_user_func($each, $value1)) {
                                        $results_ary = array('error', $key1 => $each);
                                        return $results_ary;
                                    }
                                }
                            }
                        }
                    }
                }
                return $req_method_ary;
            }
        }
    }
}
