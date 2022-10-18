<?php

namespace App\Requests;

use Core\Http\Request;
use App\Validation;

class AppRequest extends Request
{   
//     protected $request;

//     public function __construct(Request $request)
//     {
//         $this->request = $request;
//     }
    public static function validate()
    {   
        $rules = [
            'price' => [
                'required',
                'numeric',
                'filled',
            ],
            'name' => [
                'required',
                'string',
                'filled',
            ],
            'description' => [
                'max:500',
            ],];
        $request = new Request;
        $post = $request->getPost()->all();

        $arrayRequest = [];
        if (count($post) == 1) {
            $arrayRequest = $post;
        } else {
            $get = $request->getGet()->all();
            // foreach ($get as $value) {
                $arrayRequest = $get;
            // }
        }

        $ruleRequires = [];
        foreach ($rules as $keyRule => $value) {
            if (in_array('required', $value)) {
                $ruleRequires[$keyRule] = $value;
            }
        }
        // print_r($arrayRequest);
        // print_r($ruleRequires);
        // exit;
        $same = array_intersect(array_keys($ruleRequires), array_keys($arrayRequest));
        print_r($same);
        print_r(array_keys($rules));
        // print_r($diff);
        if ($same) {
            $diff = array_diff(array_keys($ruleRequires), $same);
            if ($diff) {
                    // print error require. (print theo array_value cua $diff)
                
            } else {
                foreach ($arrayRequest as $key1 => $value1) {
                    foreach ($rules as $key2 => $value2) {
                        if ($key1 == $key2) {
                            foreach ($value2 as $each) {
                                if (str_contains($each, ':')) {
                                    $eachArray =  explode(':', $each);
                                    call_user_func($eachArray[0], $eachArray[1]);
                                }
                                call_user_func($each, $value1);
                            }
                        }
                    }
                }
            }
        }
        

    }
}
