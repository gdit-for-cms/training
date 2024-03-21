<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use Exception;

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
        $name = htmlspecialchars($post->get('name'));
        $pass = $post->get('pass');
        $pass_confirm = $post->get('pass_confirm');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $display_name = htmlspecialchars($post->get('display_name'));
        $email = htmlspecialchars($post->get('email'));
        $image_data = htmlspecialchars($post->get('image_data'));

        // Store a data input in Session to give information back to form if error.

        $data_input = [
            'pre_name' => $name,
            'pre_display_name' => $display_name,
            'email' => $email
        ];

        $_SESSION['data_input'] = $data_input;

        // Render page
        if (empty($name) || empty($display_name) || empty($pass) || empty($pass_confirm) || empty($email)) {
            header('Location: /home/register');
            exit;
        } else {
            // Query the exist user
            $exist_user = $this->current_user->table('app_user')
                ->where('name', '=', $name)->first();
            $exist_display_name = $this->current_user->table('app_user')
                ->where('display_name', '=', $display_name)->first();
            $exist_email = $this->current_user->table('app_user')
                ->where('email', '=', $email)->first();
            try {
                if (!$exist_user && !$exist_display_name && !$exist_email && $pass == $pass_confirm) {
                    $userInfo = [
                        'name' => $name,
                        'pass' => $hashed_pass,
                        'display_name' => $display_name,
                        'email' => $email,
                        'img' => $image_data
                    ];

                    $create_result = $this->current_user->table('app_user')->create(
                        [
                            'name' => $userInfo['name'],
                            'pass' => $userInfo['pass'],
                            'display_name' => $userInfo['display_name'],
                            'email' => $userInfo['email'],
                            'img' => $userInfo['img']
                        ]
                    );

                    if ($create_result) {
                        $_SESSION['register_state'] = 'success';
                        header('Location: /register/register');
                        exit;
                    } else {
                        $_SESSION['register_state'] = 'error';
                        header('Location: /register/register');
                        exit;
                    }
                } else {
                    if ($exist_user && $exist_display_name) {
                        $_SESSION['register_error'] = showError('both_name_existed');
                    } else if ($exist_user) {
                        $_SESSION['register_error'] = showError('name_existed');
                    } else if ($exist_display_name) {
                        $_SESSION['register_error'] = showError('display_name_existed');
                    } else if ($exist_email) {
                        $_SESSION['register_error'] = showError('email_existed');
                    }
                    header('Location: /register/register');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['register_state'] = 'error';
                header('Location: /register/register');
                exit;
            }
        }
    }
}
