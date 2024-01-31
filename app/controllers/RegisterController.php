<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class RegisterController extends AppController {
    public array $data_ary;

    public object $current_user;

    protected function before() {
        if (isLogged()) {
            header('Location: /home/index');
            exit;
        } else if (isRegisterURL()) {
            header('Location: /register/register');
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

        // Get value 
        $name = $post->get('name');
        $pass = $post->get('pass');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $display_name = $post->get('display_name');

        // Query the exist user
        $exist_user = $this->current_user->table('app_user')
            ->where('name', '=', $name)->first();
        $exist_display_name = $this->current_user->table('app_user')
            ->where('display_name', '=', $display_name)->first();

        // Save the previous value
        $this->data_ary['pre_name'] = $name;
        $this->data_ary['pre_display_name'] = $display_name;

        // Image
        // $files =  $request->getFiles();
        // var_dump($files);
        // echo '<br>';
        // var_dump($post);
        // echo '<br>';
        // $data_upload = array();
        // $all_results = array();
        // $add_item_result = [
        //     'all_results' => [],
        //     'data_upload' => [],
        // ];

        // $file_key = 'img_code';
        // $file = $files->get($file_key);
        //var_dump($file);
        //echo '<br>';

        //
        // if (!empty($name) && ($file['size'] > 0)) {
        //     if ($file['size'] < 4000000) {
        //         $add_item_result['data_upload'][$file_key] = [
        //             'name' => $name,
        //             'file' => $file
        //         ];
        //     } else {
        //         $add_item_result['all_results']['failed'][$file_key] = 'File too large!';
        //     }
        // } else {
        //     $add_item_result['all_results']['failed'][$file_key] = 'Please enter name input and select image file!';
        // }

        // $data_upload = $add_item_result['data_upload'];
        // $all_results = $add_item_result['all_results'];

        // if (!empty($data_upload)) {
        //     foreach ($data_upload as $key => $value) {
        //         $extension = explode('.', $value['file']['name'])[1];
        //         //var_dump($extension);
        //         //echo '<br>';

        //         $file_name = $name . rand(10, 1000000) . time() . '.' . $extension;
        //         //var_dump($file_name);
        //         //echo '<br>';
        //         $file_path = 'img/qr_code/' . $file_name;
        //     }
        // }

        // Render page
        if (!$exist_user && !$exist_display_name) {
            $this->current_user->table('app_user')->create(
                [
                    'name' => $name,
                    'pass' => $hashed_pass,
                    'display_name' => $display_name
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
