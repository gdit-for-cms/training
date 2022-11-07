<?php

namespace App\Controllers\Admin;

use App\Requests\AppRequest;
use App\models\User;
use App\models\Position;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class PositionController extends AppController
{
    use ResponseTrait;

    public $title = 'Vị trí';

    public object $obj_model;

    public array $data_ary;

    public function __construct() {
        $this->obj_model = new Position;
    }

    public function indexAction() {
        $this->data_ary['positions'] = $this->obj_model->getAll();
        $this->data_ary['content'] = 'position/index';
    }

    public function newAction() {
        $array = array_diff(scandir('../app/controllers/User'), array('..', '.'));
        $result = array();
        foreach ($array as $filename) {
            array_push($result, strtolower((preg_split('/(?=[A-Z])/', $filename)[1])));
        }
        $this->data_ary['pages'] = $result;

        $this->data_ary['content'] = 'position/new';
    }

    public function create(Request $request) {
        $app_request = new AppRequest;
        $result_vali_ary = $app_request->validate(Position::rules(), $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        $name = $result_vali_ary['name'];
        $description = $result_vali_ary['description'];
        $access_page = implode(',', $result_vali_ary['access_page']);

        $position_check_ary = $this->obj_model->getBy('name', '=', $name);
        $num_rows = count($position_check_ary);

        if ($num_rows == 1) {
            return $this->errorResponse('Position has been exist');
        } else {
            try {
                $this->obj_model->create(
                    [
                        'name' => $name,
                        'description' => $description,
                        'access_page' => $access_page
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

        $array = array_diff(scandir('../app/controllers/User'), array('..', '.'));
        $result = array();
        foreach ($array as $filename) {
            array_push($result, strtolower((preg_split('/(?=[A-Z])/', $filename)[1])));
        }

        $this->data_ary['pages'] = $result;

        $this->data_ary['position'] = $this->obj_model->getById($id, 'id, name, description, access_page');

        $this->data_ary['content'] = 'position/edit';
    }

    public function update(Request $request) {
        $post_ary = $request->getPost()->all();

        $check_position = $this->obj_model->getById($post_ary['id']);
        $change_data_flg = false;

        foreach ($post_ary as $key => $value) {
            if ($key != 'access_page') {
                if ($check_position[$key] != $value) {
                    $change_data_flg = true;
                    break;
                }
            } else {
                $value = implode(',', $value);
                if ($check_position[$key] != $value) {
                    $change_data_flg = true;
                    break;
                }
            }
        }

        if (!$change_data_flg) {
            return $this->errorResponse('Nothing to update');
        }

        $app_request = new AppRequest;
        $rules_ary = Position::rules('add', ['id' => ['required', 'filled']]);
        $result_vali_ary = $app_request->validate($rules_ary, $request, 'post');

        if (in_array('error', $result_vali_ary)) {
            $message_error = showError($result_vali_ary[array_key_last($result_vali_ary)]) . " (" . array_key_last($result_vali_ary) . ")";
            return $this->errorResponse($message_error);
        }

        try {
            $id = $result_vali_ary['id'];
            $name = $result_vali_ary['name'];
            $description = $result_vali_ary['description'];
            $access_page = implode(',', $result_vali_ary['access_page']);

            $this->obj_model->updateOne(
                [
                    'name' => $name,
                    'description' => $description,
                    'access_page' => $access_page
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

        header('Location: /admin/position/index');
        exit;
    }

    public function changePosition(Request $request) {
        try {
            $post_ary = $request->getPost()->all();
            $post_ary = $post_ary['data'];
            var_dump($post_ary);
            exit;
            $obj_user = new User;
            $id_ary = array();
            foreach ($post_ary as $key => $value) {
                $position = $this->obj_model->getBy('name', '=', $value);
                $id_ary[$key] = (int)$position[0]['id'];
            }
            $obj_user->updateMultiByName($id_ary, 'position_id');
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
