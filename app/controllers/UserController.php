<?php

namespace App\Controllers;

use App\Requests\AppRequest;
use App\Models\Position;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class UserController extends AppController {
    use ResponseTrait;

    public $title = 'Người dùng';

    public object $obj_model;
    
    public array $data_ary;

    public function __construct() {
        $this->obj_model = new User;
    }

    public function indexAction(Request $request) {   
        $get_ary = $request->getGet()->all();
        
        $results_per_page = 3;
        array_shift($get_ary);
        $results_ary = $this->obj_model->getAllRelation($get_ary, $results_per_page);
        $this->data_ary['all_users'] = $results_ary['results'];
        $numbers_of_result = $results_ary['numbers_of_page'];

        $numbers_of_page = ceil($numbers_of_result/$results_per_page);
        $this->data_ary['numbers_of_page'] = $numbers_of_page;

        $this->data_ary['all_roles'] = Role::getAll();
        $this->data_ary['all_rooms'] = Room::getAll();
        $this->data_ary['all_positions'] = Position::getAll();

        $this->data_ary['content'] = 'user/index';
    }

    public function newAction() {   
        $this->data_ary['all_roles'] = Role::getAll();
        $this->data_ary['all_rooms'] = Room::getAll();
        $this->data_ary['all_positions'] = Position::getAll();

        $this->data_ary['content'] = 'user/new';
    }

    public function create(Request $request) {
        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate($this->obj_model->rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $name = $result_vali_ary['name'];
        $password = $result_vali_ary['password'];
        $email = $result_vali_ary['email'];
        $role_id = $result_vali_ary['role_id'];
        $room_id = $result_vali_ary['room_id'];
        $position_id = $result_vali_ary['position_id'];

        $user_check_ary = $this->obj_model->getBy('email', '=', $email);
        $num_rows = count($user_check_ary);

        if ($num_rows == 1) {
            return $this->errorResponse('User has been exist');
        } else {
            try {
                $this->obj_model->create(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                        'role_id' => $role_id,
                        'room_id' => $room_id,
                        'position_id' => $position_id
                    ]);

                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function editAction(Request $request) {
        $id = $request->getGet()->get('id');

        $this->data_ary['all_roles'] = Role::getAll();
        $this->data_ary['all_rooms'] = Room::getAll();
        $this->data_ary['all_positions'] = Position::getAll();
        $this->data_ary['user'] = $this->obj_model->getById($id, 'id, name, email, role_id, room_id, position_id');

        $this->data_ary['content'] = 'user/edit';
    }

    public function update(Request $request) {   
        $post_ary = $request->getPost()->all();
        
        $check_user = $this->obj_model->getById($post_ary['id']);
        $change_data_flg = false;

        foreach ($post_ary as $key => $value) {
            if ($post_ary['password'] == '' && $key != 'password' && $check_user[$key] != $value) {
                $change_data_flg = true;
                break;
            } else if ($post_ary['password'] != '' && $check_user[$key] != $value) {
                $change_data_flg = true;
                break;
            }
        }
        if (!$change_data_flg) {
            return $this->errorResponse('Nothing to update');
        }

        $app_request = new AppRequest;
        $rules_ary = $this->obj_model->rules('remove_value', ['password' => ['required', 'filled', 'password']]);
        $result_vali_ary = $app_request->validate($rules_ary, $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        } 

        $id = $result_vali_ary['id'];
        $email =$result_vali_ary['email'];

        $user_check = $this->obj_model->getBy('email', '=', $email);
        $num_rows = count($user_check);

        if ($num_rows == 1 && $user_check[0]['id'] != $id) {
            return $this->errorResponse(showError('email existed'));
        } else {
            try {
                $name = $result_vali_ary['name'];
                $password = $result_vali_ary['password'];
                $role_id = $result_vali_ary['role_id'];
                $room_id = $result_vali_ary['room_id'];
                $position_id = $result_vali_ary['position_id'];
    
                $this->obj_model->updateOne(
                    [
                        'name' => $name,
                        'password' => $password,
                        'email' => $email,
                        'role_id' => $role_id,
                        'room_id' => $room_id,
                        'position_id' => $position_id
                    ],
                    "id = $id");
                    
                return $this->successResponse();
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            };
        }
    }

    public function deleteAction(Request $request) {
        $id = $request->getGet()->get('id');

        $this->obj_model->destroyOne("id = $id");

        header('Location: /user/index');
        exit;
    }
}
