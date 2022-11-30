<?php

namespace App\Controllers\Admin;

use Core\View;
use App\models\User;
use Core\Http\Request;

class AuthController extends AppController {
    public array $data;

    protected function before() {
        if (checkAdmin()) {
            header('Location: /admin');
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
            'id' => $inputUser['id'],
            'name' => $inputUser['name'],
            'email' => $inputUser['email'],
            'role_id' => $inputUser['role_id'],
            'room_id' => $inputUser['room_id'],
            'position_id' => $inputUser['position_id'],
            'avatar_image' => $inputUser['avatar_image'],
        ];
        
        $request->saveUser($data);
        
        header('Location: /admin');
        exit;
    }

    public function logout(Request $request) {
        $request->deleteUser();
        
        header('Location: /');
        exit;
    }
}
