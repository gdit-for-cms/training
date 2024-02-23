<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\ClientException;
use PDOException;

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
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId('1535192830662504');
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

        // $_SESSION['fb_access_token'] = (string) $accessToken;

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

    // public function sendMailAction() {
    //     $email = $_POST['email'];

    //     $object_user = new User();

    //     $exist_user = $object_user->table('app_user')
    //         ->where('email', '=', $email)->first();

    //     if (!$exist_user) {
    //         $_SESSION['sent_email_status'] = 'email had not been registered';
    //         header('Location: /auth/login');
    //         exit;
    //     }

    //     $encryptedEmail = $this->encryptEmail($email);

    //     $encodedEmail = urlencode($encryptedEmail);

    //     $serverName = $_SERVER['SERVER_NAME'];
    //     $resetPassUrl = "http://$serverName/auth/reset-pass?email=$encodedEmail";

    //     // Send the email to the user with the reset password URL
    //     $subject = "Reset Your Password â";
    //     $body = "Please use the following link to reset your password: $resetPassUrl";
    //     $headers = 'From: noreply@yourdomain.com' . "\r\n" .
    //         'Reply-To: noreply@yourdomain.com' . "\r\n" .
    //         'X-Mailer: PHP/' . phpversion();

    //     mail($email, $subject, $body, $headers);

    //     $_SESSION['sent_email_status'] = 'success';
    //     header('Location: /auth/login');
    // }

    public function sendMailAction() {
        $email = $_POST['email'];

        $object_user = new User();

        $exist_user = $object_user->table('app_user')
            ->where('email', '=', $email)->first();

        if (!$exist_user) {
            $_SESSION['sent_email_status'] = 'email had not been registered';
            header('Location: /auth/login');
            exit;
        }

        $encryptedEmail = $this->encryptEmail($email);

        $encodedEmail = urlencode($encryptedEmail);

        $serverName = $_SERVER['SERVER_NAME'];
        $resetPassUrl = "http://$serverName/auth/reset-pass?email=$encodedEmail";

        // Prepare the email body
        $subject = "PHP Food Code - Reset Password";
        $body = '<html><head>';
        $body .= '<title>Password Reset Request</title>';
        $body .= '</head><body>';
        $body .= '<h2>PHP Food Code - Password Reset Notification</h2>';
        $body .= '<p>Dear, ' . $exist_user['email'] . '</p>';
        $body .= '<p>You\'re receiving this email because we received a password reset request for your account. If you did not request a password reset, no further action is required.</p>';
        $body .= '<p>To reset your password, please click on the link below:</p>';
        $body .= '<a href="' . $resetPassUrl . '" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Reset Password</a>';
        $body .= '<p>This password reset link will expire in 60 minutes. After the link has expired, you will need to request a new password reset.</p>';
        $body .= '<p>If you have any issues or did not request this action, please contact our support team.</p>';
        $body .= '<br>';
        $body .= '<p>Best Regards,</p>';
        $body .= '<p>Your PHP Food Code Team</p>';
        $body .= '</body></html>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Attempt to send the email
        if (!mail($email, $subject, $body, $headers)) {
            // Log the error or handle the failure
            echo ('Email sending failed to ' . $email);
            exit;
            $_SESSION['sent_email_status'] = 'error';
        } else {
            // If email is sent successfully
            $_SESSION['sent_email_status'] = 'success';
        }

        // Redirect to the login page
        header('Location: /auth/login');
    }

    function encryptEmail($email) {
        $method = 'AES-256-CBC';
        // Ensure the key is 32 bytes long for AES-256-CBC
        $key = openssl_digest('your_secret_key', 'SHA256', true);
        // Use a fixed IV for simplicity (not recommended for production)
        $iv = str_repeat("a", openssl_cipher_iv_length($method));

        $encrypted = openssl_encrypt($email, $method, $key, 0, $iv);
        // Base64-encode
        return base64_encode($encrypted);
    }

    public function resetPassAction(Request $request) {
        $get = $request->getGet();
        $encryptedEmail = $get->get('email');

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

        $method = 'AES-256-CBC';
        // Use the same method to generate the key as in the encryption function
        $key = openssl_digest('your_secret_key', 'SHA256', true);
        // Use the same fixed IV as in the encryption function
        $iv = str_repeat("a", openssl_cipher_iv_length($method));

        $decryptedEmail = openssl_decrypt($encrypted, $method, $key, 0, $iv);

        if (false === $decryptedEmail) {
            echo "Invalid or corrupted link.";
            return;
        }

        if (!filter_var($decryptedEmail, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            return;
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
            } else {
                $_SESSION['sent_email_status'] = 'error';
                header('Location: /auth/login');
            }
        } catch (PDOException $e) {
            var_dump($e);
            $_SESSION['sent_email_status'] = 'error';
            header('Location: /auth/login');
        }
    }

    public function logout(Request $request) {
        $request->deleteUser();
        header('Location: /');
        exit;
    }
}
