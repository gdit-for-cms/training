<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class UserController extends AppController {
    public array $data_ary;

    public object $current_user;

    protected function before() {
        if (isRegisterURL()) {
            header('Location: /user/register');
            exit;
        }

        $this->data_ary['title'] = 'Register';
    }

    protected function after() {
    }

    public function __construct() {
        $this->current_user = new User;
    }

    public function registerAction() {
        View::render('home/register.php');
    }

    public function registerProcessAction(Request $request) {
        $post = $request->getPost();
        $upload_img = $request->getFiles();
        var_dump($upload_img);

        $name = $post->get('name');
        $pass = $post->get('pass');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $display_name = $post->get('display_name');


        //////////////////////////////////////
        $image_code = $upload_img->get('img_code');

        $add_item_result['data_upload']['img_code'] = [
            'name' => $name,
            'file' => $image_code
        ];

        $path = 'myfolder/myimage.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // Image handling from Base64 to BLOB
        if (!empty($image_code)) {
            $image_code = explode(',', $image_code)[1];
            $image_code = base64_decode($image_code);
        }
        ////////////////////////////////

        $exist_user = $this->current_user->table('app_user')
            ->where('name', '=', $name)->first();
        $exist_display_name = $this->current_user->table('app_user')
            ->where('display_name', '=', $display_name)->first();

        $this->data_ary['pre_name'] = $name;
        $this->data_ary['pre_display_name'] = $display_name;

        if (!$exist_user && !$exist_display_name) {
            $this->current_user->table('app_user')->create(
                [
                    'name' => $name,
                    'pass' => $hashed_pass,
                    'display_name' => $display_name,
                    'img_code' => $image_code
                ]
            );
            $this->data_ary['create_success'] = 'Register success';
            View::render('home/login.php', $this->data_ary);
            exit;
        } else {
            if ($exist_user) {
                $this->data_ary['name_error'] = showError('name existed');
            }
            if ($exist_display_name) {
                $this->data_ary['display_name_error'] = showError('display name existed');
            }
            View::render('home/register.php', $this->data_ary);
            exit;
        }
    }
}
