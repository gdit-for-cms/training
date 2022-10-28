<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ApiController extends AppController {
    use ResponseTrait;

    public function users(Request $request) {   
        $data_ary = array();
        $results_per_page = 3;
        $post_ary = $request->getPost()->all();
        $obj_user = new User;

        if (isset($post_ary['method'])) {
            $data_ary = $obj_user->getBy($post_ary['name_field'], '=', $post_ary['id'], 'name');

            return $this->successResponse($data_ary);
        } else {
            $data_ary = $obj_user->getByRelation($post_ary, $post_ary['name_field'], $results_per_page);

            $numbers_of_page = ceil($data_ary['numbers_of_page']/$results_per_page);
            $data_ary['numbers_of_page'] = $numbers_of_page;
            $data_ary['page'] = $post_ary['page'];
            return $this->successResponse($data_ary);
        }
    }
}
