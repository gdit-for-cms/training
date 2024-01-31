<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class AuthController extends AppController {
    public array $data_ary;

    protected function before() {
        // Can check Auth here
        if (isLogged()) {
            header('Location: /home/index');
            exit;
        }

        $this->data_ary['title'] = 'Login';
    }

    protected function after() {
    }

    public function loginAction() {
        View::render('home/login.php');
    }

    public function loginProcessAction(Request $request) {
        $post = $request->getPost();

        $name = $post->get('name');
        $pass = $post->get('pass');

        $user = new User();
        $exist_user = $user->table('app_user')
            ->where('name', '=', $name)->first();

        $this->data_ary['pre_name'] = $name;

        if (!$exist_user) {
            $this->data_ary['name_error'] = showError('login name');
            View::render('home/login.php', $this->data_ary);
            exit;
        }

        $exist_password = $exist_user['pass'];

        if (password_verify($pass, $exist_password)) {
            $data_ary = [
                'id' => $exist_user['id'],
                'name' => $exist_user['name'],
                'display_name' => $exist_user['display_name'],
                'img' => $exist_user['img'],
            ];
        } else {
            $this->data_ary['pass_error'] = showError('login password');
            View::render('home/login.php', $this->data_ary);
            exit;
        };

        $request->saveUser($data_ary);

        header('Location: /home/index');
        exit;
    }

    public function logout(Request $request) {
        $request->deleteUser();
        header('Location: /');
        exit;
    }
}
