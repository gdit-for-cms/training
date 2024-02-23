<?php

namespace App\Controllers;

use App\Models\Token;
use Core\View;
use App\models\User;
use Core\Http\Request;
use Exception;
use Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\ClientException;
use PDOException;
use PHPMailer\PHPMailer;

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

        $name = htmlspecialchars($post->get('name'));
        $pass = $post->get('pass');

        $user = new User();
        $exist_user = $user->table('app_user')
            ->where('name', '=', $name)->first();

        if ($exist_user == null) {
            $_SESSION['name_error'] = showError('login name');
            $_SESSION['pre_name'] = $name;
            header('Location: /auth/login');
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
            $_SESSION['pass_error'] = showError('login password');
            $_SESSION['pre_name_pass'] = $name;
            header('Location: /auth/login');
            exit;
        };

        $request->saveUser($data_ary);

        $referer = $_SESSION['previous_url'] ?? '/home/index';

        unset($_SESSION['previous_url']);

        header("Location: $referer");
        exit;
    }

    public function facebookLoginAction(Request $request) {

        $fb = new Facebook\Facebook([
            'app_id' => $_ENV['FACEBOOK_APP_ID'],
            'app_secret' => $_ENV['FACEBOOK_APP_SECRET'],
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            $_SESSION['fb_login_err'] = 'Lỗi trong quá trình đăng nhập bằng Facebook';
            header('Location: /auth/login');
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $_SESSION['fb_login_err'] = 'Lỗi trong quá trình đăng nhập bằng Facebook';
            header('Location: /auth/login');
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
                $_SESSION['fb_login_err'] = 'Lỗi trong quá trình đăng nhập bằng Facebook';
                header('Location: /auth/login');
                exit;
            } else {
                $_SESSION['fb_login_err'] = 'Lỗi trong quá trình đăng nhập bằng Facebook';
                header('Location: /auth/login');
                exit;
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId($_ENV['FACEBOOK_APP_ID']);
        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }
        }

        // Request for user data
        try {
            $response = $fb->get('/me?fields=id,name,email,picture.type(normal)', $accessToken);
            $user_fb = $response->getGraphUser();

            // Accessing the profile picture URL
            $picture = $user_fb['picture'];
            if ($picture) {

                $picture_url = $picture->getUrl();
                $client = new Client();

                $promises = [
                    'image' => $client->getAsync($picture_url),
                ];

                // Wait for the requests to complete
                $results = Promise\Utils::unwrap($promises);

                // Access the results
                $imageResponse = $results['image'];

                // Convert the responses to binary data
                $image_data = $imageResponse->getBody()->getContents();
            }
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        } catch (ClientException $e) {
            $picture_url = 'https://static.vecteezy.com/system/resources/previews/009/734/564/original/default-avatar-profile-icon-of-social-media-user-vector.jpg';
        }

        $object_user = new User();

        $user_data = [];

        if ($object_user->getBy('email', '=', $user_fb['email']) == null) {
            $user_data = [
                'name' => $user_fb['email'],
                'pass' => password_hash('123456', PASSWORD_BCRYPT),
                'display_name' => $user_fb['name'],
                'email' => $user_fb['email'],
                'img' => $picture_url
            ];
            $object_user->create($user_data);
        }

        // Fetch user in DB
        $exist_user = $object_user->table('app_user')
            ->where('email', '=', $user_fb['email'])->first();

        $data_ary = [
            'id' => $exist_user['id'],
            'name' => $exist_user['name'],
            'display_name' => $exist_user['display_name'],
            'img' => $exist_user['img'],
        ];

        $request->saveUser($data_ary);

        $referer = $_SESSION['previous_url'] ?? '/home/index';

        unset($_SESSION['previous_url']);

        header("Location: $referer");
        exit;
    }

    public function sendMailAction(Request $request) {

        $username = $request->getPost()->get('username');

        $object_user = new User();

        $exist_user = $object_user->table('app_user')
            ->where('name', '=', $username)->first();

        if (!$exist_user) {
            $_SESSION['sent_email_status'] = 'not_register';
            header('Location: /auth/login');
            exit;
        }
        // If user existed
        // Generate a random IV with expiration 60 minutes
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['METHOD_ENCRYPT_A']));
        // Base64 encode the IV to ensure it's in a safe format to store in the DB
        $encodedIv = base64_encode($iv);
        $expiration = time() + 60;

        // Save Initialization Vector as token to DB
        $object_token = new Token();
        // Check if a token already exists for the user
        $existingToken = $object_token->findByUserId($exist_user['id']);

        if ($existingToken) {
            // Token exists, so update it
            $object_token->updateToken([
                'value' => $encodedIv,
                'expiration' => $expiration
            ], "id = " . $exist_user['id']);
        } else {
            // No token exists, create a new one
            $object_token->create([
                'id' => $exist_user['id'],
                'value' => $encodedIv,
                'expiration' => $expiration
            ]);
        }
        $email = $exist_user['email'];

        $encryptedEmail = $this->encryptEmail($email);
        $encodedEmail = urlencode($encryptedEmail);
        $serverName = $_SERVER['SERVER_NAME'];
        $resetPassUrl = "http://$serverName/auth/reset-pass?field=$encodedEmail";


        $mail = new PHPMailer\PHPMailer(true);

        try {
            $mail->isSendmail();
            $mail->Sendmail = '/usr/bin/env catchmail --smtp-ip 192.168.1.209 -f cms8341-test-mail@glode.co.jp';

            // Recipients
            $mail->setFrom('no_reply@phpfoodcode.com', 'Mailer');
            $mail->addAddress($email, 'Recipient Name');

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'PHP Food Code - Đặt Lại Mật Khẩu';


            $name = htmlspecialchars($exist_user['display_name'], ENT_QUOTES, 'UTF-8');
            $resetLink = htmlspecialchars($resetPassUrl, ENT_QUOTES, 'UTF-8');

            $body = '<html><head>';
            $body .= '<title>Yêu Cầu Đặt Lại Mật Khẩu</title>';
            $body .= '</head><body>';
            $body .= '<h2>PHP Food Code - Thông Báo Đặt Lại Mật Khẩu</h2>';
            $body .= '<p>Kính gửi, ' . $name . '</p>';
            $body .= '<p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nếu bạn không yêu cầu đặt lại mật khẩu, không cần thực hiện thêm bất kỳ hành động nào.</p>';
            $body .= '<p>Để đặt lại mật khẩu của bạn, vui lòng nhấp vào liên kết dưới đây:</p>';
            $body .= '<a href="' . $resetLink . '" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Đặt Lại Mật Khẩu</a>';
            $body .= '<p>Liên kết đặt lại mật khẩu này sẽ hết hạn trong 1 phút. Sau khi liên kết hết hạn, bạn sẽ cần yêu cầu đặt lại mật khẩu mới.</p>';
            $body .= '<p>Nếu bạn gặp bất kỳ vấn đề nào hoặc không yêu cầu hành động này, vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi.</p>';
            $body .= '<br>';
            $body .= '<p>Trân trọng,</p>';
            $body .= '<p>Đội Ngũ PHP Food Code</p>';
            $body .= '</body></html>';

            $mail->Body = $body;


            // Set the email format to HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Continue setting other properties like Subject, AltBody, and Recipients as before...
            $mail->Subject = 'PHP Food Code - Đặt Lại Mật Khẩu';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Send the email
            $mail->send();
            $_SESSION['sent_email_status'] = 'success';
        } catch (Exception $e) {
            error_log('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
            $_SESSION['sent_email_status'] = 'error';
        }

        header('Location: /auth/login');
    }


    function encryptEmail($email) {
        // Ensure the key is 32 bytes long for AES-256-CBC
        $key = openssl_digest($_ENV['SECRET_KEY'], 'SHA256', true);

        $encrypted = openssl_encrypt($email, $_ENV['METHOD_ENCRYPT_B'], $key, 0);
        // Base64-encode
        return base64_encode($encrypted);
    }

    public function resetPassAction(Request $request) {
        $get = $request->getGet();
        $encryptedEmail = $get->get('field');

        if (!isset($encryptedEmail)) {
            echo "Invalid request.";
            return;
        }

        // Base64-decode
        $encrypted = base64_decode(urldecode($encryptedEmail));
        if (!$encrypted) {
            echo "Invalid or corrupted link.";
            return;
        }

        $key = openssl_digest($_ENV['SECRET_KEY'], 'SHA256', true);

        $decryptedEmail = openssl_decrypt($encrypted, $_ENV['METHOD_ENCRYPT_B'], $key, 0);


        $object_user = new User();

        $exist_user = $object_user->table('app_user')
            ->where('email', '=', $decryptedEmail)->first();

        if (!$exist_user) {
            $_SESSION['sent_email_status'] = 'error';
            header('Location: /auth/login');
            exit;
        }

        // Fetch Initialization Vector in DB and check expiration
        // Initialize the Token model
        $object_token = new Token();

        // Fetch the token for the user
        $token = $object_token->findByUserId($exist_user['id']);

        if ($token) {
            $expiration = $token['expiration'];
            $currentTime = time();

            if ($currentTime > $expiration) {
                $_SESSION['sent_email_status'] = 'token_expire';
                header('Location: /auth/login');
                exit;
            }
        }

        if (false === $decryptedEmail) {
            $_SESSION['sent_email_status'] = 'error';
            header('Location: /auth/login');
            exit;
        }

        $_SESSION['decrypted_email'] = $decryptedEmail;
        View::render('home/reset_pass.php');
    }

    public function changePassAction(Request $request) {
        $post = $request->getPost();
        $email = $post->get('email');
        $object_user = new User();
        $pass = $post->get('pass');
        $pass_confirm = $post->get('pass_confirm');
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $exist_user = $object_user->table('app_user')
            ->where('email', '=', $email)->first();

        $idSanitized = intval($exist_user['id']);

        $condition = "email = '$email' AND id = $idSanitized";

        try {
            if ($exist_user && $pass == $pass_confirm && $exist_user['email'] == $email) {
                $data = [
                    'pass' => $hashed_pass
                ];
                $object_user->updateUser($data, $condition);
                $_SESSION['sent_email_status'] = 'change_pass_success';
                header('Location: /auth/login');
                exit;
            } else {
                $_SESSION['sent_email_status'] = 'error';
                header('Location: /auth/login');
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['sent_email_status'] = 'error';
            header('Location: /auth/login');
            exit;
        }
    }

    public function logout(Request $request) {
        $request->deleteUser();
        header('Location: /');
        exit;
    }
}
