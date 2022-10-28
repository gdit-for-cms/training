<?php

namespace App\Controllers;

use App\Requests\AppRequest;
use App\models\User;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class RoomController extends AppController {
    use ResponseTrait;

    public $title = 'Phòng';

    public object $obj_model;
    
    public array $data_ary;

    public function __construct() {
        $this->obj_model = new Room;
    }

    public function indexAction() {   
        $results_ary = User::getAllRelation();

        $this->data_ary['rooms'] = $this->obj_model->getAll();
        $this->data_ary['content'] = 'room/index';
    }

    public function newAction() {   
        $this->data_ary['content'] = 'room/new';
    }

    public function create(Request $request) {   
        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate(Room::rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        } 

        $name = $result_vali_ary['name'];
        $description = $result_vali_ary['description'];

        $room_check_ary = $this->obj_model->getBy('name', '=', $name);
        $num_rows = count($room_check_ary);

        if ($num_rows == 1) {
            return $this->errorResponse('Room has been exist');
        } else {
            try {
                $this->obj_model->create(
                    [
                        'name' => $name,
                        'description' => $description
                    ]
                );
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request) {
        $id = $request->getGet()->get('id');

        $this->data_ary['room'] = $this->obj_model->getById($id, 'id, name, description');
        $this->data_ary['content'] = 'room/edit';
    }

    public function update(Request $request) {   
        $post_ary = $request->getPost()->all();
        $check_room = $this->obj_model->getById($post_ary['id']);
        $change_data_flg = false;

        foreach ($post_ary as $key => $value) {
            if ($check_room[$key] != $value) {
                $change_data_flg = true;
                break;
            }
        }
        if (!$change_data_flg) {
            return $this->errorResponse('Nothing to update');
        }

        $app_request = new AppRequest;
        $rules_ary = Room::rules('add', ['id' => ['required', 'filled']]);
        $result_vali_ary = $app_request->validate($rules_ary, $request, 'post');
        
        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        } 

        try {
            $id = $result_vali_ary['id'];
            $name = $result_vali_ary['name'];
            $description = $result_vali_ary['description'];

            $this->obj_model->updateOne(
                [
                    'name' => $name,
                    'description' => $description
                ],
                "id = $id"
            );

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function delete(Request $request) {
        $id = $request->getGet()->get('id');

        $this->obj_model->destroyOne("id = $id");

        header('Location: /room/index');
        exit;
    }

    public function changeRoom(Request $request) {
        try {
            $post_ary = $request->getPost()->all();
            $post_ary = $post_ary['data'];

            $obj_user = new User;
            $array_id_ary = array();

            foreach ($post_ary as $key => $value) {
                $room = $this->obj_model->getBy('name', '=', $value);
                $array_id_ary[$key] = (int)$room[0]['id'];
            }
            $obj_user->updateMultiByName($array_id_ary, 'room_id');

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
