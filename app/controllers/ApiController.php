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
        $data = $user->getByRelation($post, 'room_id', $resultsPerPage);
        // var_dump($data);
        // exit;
        return $this->successResponse($data);
    }
}