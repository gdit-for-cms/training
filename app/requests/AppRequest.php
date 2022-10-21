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
        $arrayRequest = array();
        if ($method == 'post') {
            $arrayRequest = $request->getPost()->all();
        } else {
            $get = $request->getGet()->all();
            array_shift($get);
            $arrayRequest = $get;
        }

        if ($arrayRequest == []) {
            header('Location: /room/new');
            exit;
        }

        $ruleRequires = array();
        foreach ($rules as $keyRule => $value) {
            if (in_array('required', $value)) {
                $ruleRequires[$keyRule] = $value;
            }
        }

        $same = array_intersect(array_keys($ruleRequires), array_keys($arrayRequest));

        if ($same) {
            $diff = array_diff(array_keys($ruleRequires), $same);
            if ($diff) {
                return ['error', $diff[array_key_first($diff)] => 'required'];
            } else {
                foreach ($arrayRequest as $key1 => $value1) {
                    foreach ($rules as $key2 => $value2) {
                        if ($key1 == $key2) {
                            foreach ($value2 as $each) {
                                if (strpos($each, ':') !== false) {
                                    $eachArray =  explode(':', $each);
                                    if (function_exists($eachArray[0]) && !call_user_func($eachArray[0], $eachArray[1], $value1)) {
                                        return ['error', $key1 => $eachArray[0]];
                                    }
                                } else {
                                    if (function_exists($each) && !call_user_func($each, $value1)) {
                                        return ['error', $key1 => $each];
                                    }
                                }
                            }
                        }
                    }
                }
                return $arrayRequest;
            }
        }
    }
}
