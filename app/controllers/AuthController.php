<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class AuthController extends AppController {
    public array $data_ary;

    protected function before() {
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

        $username = $post->get('name');
        $password = $post->get('pass');

        $user = new User();
        $exist_user = $user->table('app_user')
            ->where('name', '=', $username)->first();

        if (!$exist_user) {
            $this->data_ary['error'] = showError('login');

            View::render('home/login.php', $this->data_ary);
            exit;
        }

        $exist_password = $exist_user['pass'];

        if (password_verify($password, $exist_password)) {
            $data_ary = [
                'id' => $exist_user['id'],
                'name' => $exist_user['name'],
                'display_name' => $exist_user['display_name'],
                'img_code' => $exist_user['img_code'],
            ];
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
