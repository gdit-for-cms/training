<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ApiController extends AppController
{
    use ResponseTrait;

    public function users(Request $request)
    {   
        $resultsPerPage = 3;
        $post = $request->getPost()->all();
        $user = new User;

        $data = $user->getByRelation($post, $post['nameField'], $resultsPerPage);

        $numbersOfPage = ceil($data['numbersOfPage']/$resultsPerPage);
        $data['numbersOfPage'] = $numbersOfPage;
        $data['page'] = $post['page'];
        return $this->successResponse($data);
    }
}
