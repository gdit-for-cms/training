<?php

namespace App\Controllers;

use App\Models\Topic;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ApiController extends AppController
{
    use ResponseTrait;

    public function topics(Request $request)
    {
        $request = $request->getGet();
        $topic = new Topic();
        $query = $topic->table('topic');
        $q = '';
        if ($request->get('q')) {
            $q = $request->get('q');
        }
        $data = $query->where('name', 'like' , '%' . $q . '%')->get('id, name');
        return $this->successResponse($data);
    }
}
