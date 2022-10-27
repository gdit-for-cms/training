<?php

namespace App\Controllers;

use App\Models\Topic;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class TopicController extends AppController
{
    use ResponseTrait;
    public array $data;

    public function listAction() {
        $this->data['topics'] = Topic::all();
        $this->data['content'] = 'topic/list';
    }

    public function newAction() {
        $this->data['content'] = 'topic/new';
    }

    public function create(Request $request) {
        try {
            $name = $request->getPost()->get('name');
            Topic::create(['name' => $name]);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(Request $request) {
        try {
            $name = $request->getPost()->get('name');
            $id = $request->getPost()->get('id');
            Topic::updateTopic(['name' => $name], "id = $id");
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function delete(Request $request) {
        try {
            $id = $request->getGet()->get('id');
            Topic::delete($id);
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function apiCheckName(Request $request) {
        $name = $request->getGet()->get('name');
        $check = Topic::checkExist($name);
        
        return $this->successResponse((int)$check['mycheck']);
    }
}
