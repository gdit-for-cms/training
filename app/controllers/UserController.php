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

        $name = $post->get('name');
        $pass = $post->get('pass');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $display_name = $post->get('display_name');

        $exist_user = $this->current_user->table('app_user')
            ->where('name', '=', $name)->first();

        if ($exist_user) {
            $this->data_ary['name_error'] = showError('name existed');
            View::render('home/register.php', $this->data_ary);
            exit;
        } else {
            $this->current_user->table('app_user')->create(
                [
                    'name' => $name,
                    'pass' => $hashed_pass,
                    'display_name' => $display_name
                ]
            );
            $this->data_ary['create_success'] = 'Register success';
            View::render('home/register.php', $this->data_ary);
            exit;
        }
    }
}
