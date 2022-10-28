<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;

class AuthController extends AppController {
    public array $data;

    protected function before() {
        if (checkAdmin()) {
            header('Location: /admin/index');
            exit;
        }
        
        $this->data['title'] = 'Login';
    }

    protected function after() {
    }

    public function loginAction() {
        View::render('admin/auth/login.php');
    }

    public function loginProcessAction(Request $request) {
        $post = $request->getPost();

        $email = $post->get('email');
        $password = $post->get('password');

        $user = new User();
        $inputUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->where('role_id', '=', 1)
                     ->first();

        if (!$inputUser) {
            $this->data['error'] = showError('login');

            View::render('admin/auth/login.php', $this->data);
            exit;
        }

        $data = [
            'name' => $inputUser['name'],
            'email' => $inputUser['email'],
            'role_id' => $inputUser['role_id'],
            'room_id' => $inputUser['room_id'],
        ];
        
        $request->saveUser($data);
        
        header('Location: /admin/index');
        exit;

    }

    public function logout(Request $request) {
        $request->deleteUser();
        
        header('Location: /auth/login');
        exit;
    }
}
