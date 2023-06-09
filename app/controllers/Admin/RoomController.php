<?php

namespace App\Controllers\Admin;

use App\Models\Permission;
use App\Models\PermissionRoom;
use App\Requests\AppRequest;
use App\models\User;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class RoomController extends AppController
{
    use ResponseTrait;

    public $title = 'Phòng';

    private object $obj_model;
    private object $permission;
    private object $permission_room;


    public array $data_ary;

    public function __construct()
    {
        $this->obj_model = new Room;
        $this->permission = new Permission;
        $this->permission_room = new PermissionRoom;
    }

    public function indexAction()
    {
        $permission_ary = $this->permission->getAll();
        $this->data_ary['permission_ary'] = $permission_ary;
        $this->data_ary['rooms'] = $this->obj_model->getAll();
        $this->data_ary['content'] = 'room/index';
    }

    public function newAction()
    {
        $permission_ary = $this->permission->getAll();
        $this->data_ary['permission_ary'] = $permission_ary;
        $this->data_ary['content'] = 'room/new';
    }

    public function create(Request $request)
    {
        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate(Room::rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $name = $result_vali_ary['name'];
        $description = $result_vali_ary['description'];
        $permission_ids = $request->getPost()->get('permission_id');
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
                $new_room = $this->obj_model->getBy('name', '=', $name)[0];
                if (!empty($permission_ids)) {
                    foreach ($permission_ids as $id) {
                        $this->permission_room->create([
                            'room_id' => $new_room['id'],
                            'permission_id' => $id
                        ]);
                    }
                }
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request)
    {
        $id = $request->getGet()->get('id');

        $permission_ary = $this->permission->getAll();
        $permission_ids_by_room_id = $this->permission_room->getPermissionIdsByRoomId($id);

        $this->data_ary['permission_ids_by_room_id'] = $permission_ids_by_room_id;
        $this->data_ary['permission_ary'] = $permission_ary;
        $this->data_ary['room'] = $this->obj_model->getById($id, 'id, name, description');
        $this->data_ary['content'] = 'room/edit';
    }

    public function update(Request $request)
    {
        $post_ary = $request->getPost()->all();

        $check_room = $this->obj_model->getById($post_ary['id']);

        $cur_permissions_ary = $this->permission_room->getPermissionIdsByRoomId($post_ary['id']);
        $change_data_flg = false;
        foreach ($post_ary as $key => $value) {
            if ($key != 'permission_id') {
                if ($check_room[$key] != $value) {
                    $change_data_flg = true;
                    break;
                }
            } else {
                if (array_diff($value, $cur_permissions_ary) != array_diff($cur_permissions_ary, $value)) {
                    $change_data_flg = true;
                    break;
                }
            }
        }

        if (!$change_data_flg) {
            return $this->errorResponse('Nothing to update');
        }

        $app_request = new AppRequest;
        $rules_ary = Room::rules('add', ['id' => ['required', 'filled']]);
        $result_vali_ary = $app_request->validate($rules_ary, $request, 'post');
        $new_permission_ids = $post_ary['permission_id'];

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

            if (!empty($new_permission_ids)) {
                if ($this->permission_room->destroyOne("room_id=$id")) {
                    foreach ($new_permission_ids as $new_id) {
                        $this->permission_room->create([
                            'room_id' => $id,
                            'permission_id' => $new_id
                        ]);
                    }
                } else {
                    return $this->errorResponse('Can not update permission for this room!');
                }
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        };
    }

    public function delete(Request $request)
    {

        try {
            $id = $request->getGet()->get('id');
            $this->permission_room->destroyOne("room_id=$id");
            $this->obj_model->destroyOne("id = $id");
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function changeRoom(Request $request)
    {
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
