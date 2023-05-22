<?php

namespace App\Controllers;

use App\models\Topic;
use Core\Controller;
use Core\View;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\ResponseTrait;

class TopicController extends Controller
{
    use ResponseTrait;
    public array $data;

    public function listAction()
    {
        $this->data['topics'] = Topic::all();
        $this->data['content'] = 'topic/list';
    }

    public function newAction()
    {
        $this->data['content'] = 'topic/new';
    }

    public function create(Request $request)
    {
        try {
            $name = $request->getPost()['name'];
            Topic::create($name);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        // try {
        //     $id = $request->getGet()->get('id');
        //     // Topic::de($name);
        //     echo $this->successResponse();
        // } catch (\Throwable $th) {
        //     echo $this->errorResponse($th->getMessage());
        // }
    }

    public function apiCheckName(Request $request)
    {
        $name = $request->getGet()['name'];
        $check = Topic::checkExist($name);
        return $this->successResponse((int)$check['mycheck']);
    }
}
