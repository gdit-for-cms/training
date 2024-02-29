<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use PDOException;
use RedisException;
use PHPMailer\PHPMailer;
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

                    // Generate a random token
                    $token = bin2hex(random_bytes(32));
                    // Encrypt token
                    $encrypted_token = openssl_encrypt($token, $_ENV['METHOD_ENCRYPT'], $_ENV['SECRET_KEY'], 0, hex2bin($_ENV['INITIALIZATION_VECTOR_HEX']));

                    try {
                        $redis = new \Redis();
                        $redis->connect($_SERVER['SERVER_ADDR'], 6379);
                    } catch (RedisException $e) {
                        // Handle connection error
                        echo "Failed to connect to Redis server: " . $e->getMessage();
                    }

                    // Set token
                    $redis->setex("verificationToken:$encrypted_token", 3600, json_encode($userInfo));
                    // Set userInfo
                    $redis->setex("userInfo:$email", 3600, json_encode($userInfo));

                    // Send verification email:
                    if ($this->sendMailAction($email, $encrypted_token)) {
                        $_SESSION['register_state'] = 'send_mail_success';
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

    function sendMailAction($email, $token) {

        $encode_verification = urlencode($token);
        $serverName = $_SERVER['SERVER_NAME'];
        $verification_url = "http://$serverName/register/verify?verification=$encode_verification";


        $mail = new PHPMailer\PHPMailer(true);

        try {
            $mail->isSendmail();
            $mail->Sendmail = '/usr/bin/env catchmail --smtp-ip ' . $_SERVER['SERVER_ADDR'] . ' -f cms8341-test-mail@glode.co.jp';

            // Recipients
            $mail->setFrom('no_reply@phpfoodcode.com', 'Mailer');
            $mail->addAddress($email, 'Recipient Name');

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'PHP Food Code - Đặt Lại Mật Khẩu';


            $name = htmlspecialchars('Quý khách hàng', ENT_QUOTES, 'UTF-8');
            $verification_link = htmlspecialchars($verification_url, ENT_QUOTES, 'UTF-8');

            $body = '<html><head>';
            $body .= '<title>Xác Thực Email</title>';
            $body .= '</head><body>';
            $body .= '<h2>PHP Food Code - Xác Thực Địa Chỉ Email Của Bạn</h2>';
            $body .= '<p>Kính gửi, ' . $name . '</p>';
            $body .= '<p>Bạn nhận được email này vì bạn đã đăng ký tài khoản trên PHP Food Code. Để hoàn tất quá trình đăng ký, bạn cần xác thực địa chỉ email của mình.</p>';
            $body .= '<p>Để xác thực email của bạn, vui lòng nhấp vào liên kết dưới đây:</p>';
            $body .= '<a href="' . $verification_link . '" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Xác Thực Email</a>';
            $body .= '<p>Liên kết xác thực này sẽ hết hạn trong 1 giờ. Sau khi liên kết hết hạn, bạn sẽ cần yêu cầu xác thực mới.</p>';
            $body .= '<p>Nếu bạn không tạo tài khoản trên PHP Food Code, bạn có thể bỏ qua email này.</p>';
            $body .= '<br>';
            $body .= '<p>Trân trọng,</p>';
            $body .= '<p>Đội Ngũ PHP Food Code</p>';
            $body .= '</body></html>';

            $mail->Body = $body;

            // Set the email format to HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Continue setting other properties like Subject, AltBody, and Recipients as before...
            $mail->Subject = 'PHP Food Code - Xác Thực Email';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Send the email
            $mail->send();
            return TRUE;
        } catch (Exception $e) {
            error_log('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
            return FALSE;
        }
    }

    public function verifyAction(Request $request) {
        $get = $request->getGet();
        $token = $get->get('verification');

        try {
            $redis = new \Redis();
            $redis->connect($_SERVER['SERVER_ADDR'], 6379);
        } catch (RedisException $e) {
            // Handle connection error
            echo "Failed to connect to Redis server: " . $e->getMessage();
        }

        // Fetch token from Redis
        $userInfoJson = $redis->get("verificationToken:$token");
        if ($userInfoJson) {
            $userInfo = json_decode($userInfoJson, true);

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
                $redis->del("verificationToken:$token");
                $_SESSION['register_state'] = 'success';
                header('Location: /register/register');
                exit;
            } else {
                $_SESSION['register_state'] = 'error';
                header('Location: /register/register');
                exit;
            }
        } else {
            $_SESSION['register_state'] = 'send_mail_expire';
            header('Location: /register/register');
            exit;
        }
    }

    public function resendEmailAction(Request $request) {
        $post = $request->getPost();
        $email = $post->get('email');

        try {
            $redis = new \Redis();
            $redis->connect($_SERVER['SERVER_ADDR'], 6379);
        } catch (RedisException $e) {
            // Handle connection error
            echo "Failed to connect to Redis server: " . $e->getMessage();
        }

        // Fetch token from Redis
        $userInfoJson = $redis->get("userInfo:$email");

        if ($userInfoJson) {
            // Generate a random token
            $token = bin2hex(random_bytes(32));
            // Encrypt token
            $encrypted_token = openssl_encrypt($token, $_ENV['METHOD_ENCRYPT'], $_ENV['SECRET_KEY'], 0, hex2bin($_ENV['INITIALIZATION_VECTOR_HEX']));

            // Set token
            $redis->setex("verificationToken:$encrypted_token", 3600, $userInfoJson);
        } else {
            $_SESSION['register_state'] = 'send_mail_expire';
            header('Location: /register/register');
            exit;
        }

        // Send verification email:
        if ($this->sendMailAction($email, $encrypted_token)) {
            $_SESSION['register_state'] = 'send_mail_success';
            header('Location: /register/register');
            exit;
        } else {
            $_SESSION['register_state'] = 'error';
            header('Location: /register/register');
            exit;
        }
    }
}
