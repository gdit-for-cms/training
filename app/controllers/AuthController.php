<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\ClientException;

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

    public function loginAction(Request $request) {

        if ($request->getGet()->has('pre_name')) {
            $name = $request->getGet()->get('pre_name');
            $this->data_ary['pre_name'] = $name;
            View::render('home/login.php', $this->data_ary);
            exit;
        } else {
            View::render('home/login.php');
        }
    }

    public function loginProcessAction(Request $request) {
        $post = $request->getPost();

        $name = htmlspecialchars($post->get('name'));
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

        $referer = $_SESSION['previous_url'] ?? '/home/index';

        unset($_SESSION['previous_url']);

        header("Location: $referer");
        exit;
    }

    public function facebookLoginAction(Request $request) {

        $fb = new Facebook\Facebook([
            'app_id' => '1535192830662504',
            'app_secret' => '02c132f5cc9b005bf5c9dac5eb2cd0f0',
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
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


    public function logout(Request $request) {
        $request->deleteUser();
        header('Location: /');
        exit;
    }
}
