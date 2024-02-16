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
        $name = htmlspecialchars($post->get('name'));
        $pass = $post->get('pass');
        $pass_confirm = $post->get('pass_confirm');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $display_name = htmlspecialchars($post->get('display_name'));
        $image_data = $post->get('image_data');
        // Decode base64 image
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image_data));

        // Save the previous value
        $this->data_ary['pre_name'] = $name;
        $this->data_ary['pre_display_name'] = $display_name;

        // Validate
        // function validate() {
        // }

        // Render page
        if (empty($name) || empty($display_name) || empty($pass) || empty($pass_confirm)) {
            $this->data_ary['register_error'] = showError('none register value');
            View::render('home/register.php', $this->data_ary);
            exit;
        } else {
            // Query the exist user
            $exist_user = $this->current_user->table('app_user')
                ->where('name', '=', $name)->first();
            $exist_display_name = $this->current_user->table('app_user')
                ->where('display_name', '=', $display_name)->first();

            if (!$exist_user && !$exist_display_name && $pass == $pass_confirm) {
                $this->current_user->table('app_user')->create(
                    [
                        'name' => $name,
                        'pass' => $hashed_pass,
                        'display_name' => $display_name,
                        'img' => $image_data
                    ]
                );
                $this->data_ary['register_state'] = 'success';
                View::render('home/register.php', $this->data_ary);
                exit;
            } else {
                if ($exist_user && $exist_display_name) {
                    $this->data_ary['register_error'] = showError('both name existed');
                } else if ($exist_user) {
                    $this->data_ary['register_error'] = showError('name existed');
                } else if ($exist_display_name) {
                    $this->data_ary['register_error'] = showError('display name existed');
                }

                View::render('home/register.php', $this->data_ary);
                exit;
            }
        }
    }
}
