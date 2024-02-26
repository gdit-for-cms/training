<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use Exception;

class UserController extends AppController {
    use ResponseTrait;

    public array $data_ary;

    public $title = 'User';


    public function showAction(Request $request) {
        $current_user = $request->getUser();
        // Get data user
        $object_user = new User();
        $user_data = $object_user->getBy('id', '=', $current_user['id']);

        // If after update
        if ($request->getGet()->has('update')) {
            $update_status = $request->getGet()->get('update');
            $this->data_ary['update_status'] = $update_status;
        }


        $this->data_ary['user_data'] = $user_data;
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = '/user/display';
        View::render('/layouts/master.php', $this->data_ary);
    }

    public function lookupAction(Request $request) {
        $clientId = 'fd7324df-4819-419c-abce-15a87efb7efb'; // x-client-id of VietQR
        $apiKey = '830b441c-7f7c-4609-b61d-cc180ea12936'; // x-api-key of VietQR

        $post = $request->getPost();

        $bin = $post->get('bin');
        $account_number = $post->get('accountNumber'); // API endpoint
        $url = 'https://api.vietqr.io/v2/lookup';

        // Prepare the POST fields
        $data = array(
            'bin' => $bin,
            'accountNumber' => $account_number,
        );

        // Initialize cURL
        $ch = curl_init($url);

        // Set the request method to POST
        curl_setopt($ch, CURLOPT_POST, true);

        // Set the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Set the headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-client-id: ' . $clientId,
            'x-api-key: ' . $apiKey,
        ));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL
        curl_close($ch);

        // Output the result
        header('Content-Type: application/json');
        return $this->successResponse($result, 'Had response');
        exit;
    }

    public function updateAction(Request $request) {
        $current_user = $request->getUser();
        $current_user_id = $current_user['id'];
        $post = $request->getPost();
        $image_data = $post->get('image_data');
        $image_code = $post->get('image_code');
        if ($image_code == 'no_code') {
            $image_code = null;
        }
        $display_name = htmlspecialchars(trim($post->get('display_name')));
        $bank_bin = htmlspecialchars($post->get('bank_bin'));
        $bank_acc = htmlspecialchars($post->get('bank_acc'));
        $update_data = [
            'img' => $image_data,
            'img_code' => $image_code,
            'display_name' => $display_name,
            'bank_bin' => $bank_bin,
            'bank_acc' => $bank_acc
        ];

        $object_user = new User();

        try {
            if ($object_user->updateUser($update_data, "id = $current_user_id")) {
                $user_data = $object_user->getBy('id', '=', $current_user['id']);
                $data_ary = [
                    'id' => $user_data[0]['id'],
                    'name' => $user_data[0]['name'],
                    'display_name' => $user_data[0]['display_name'],
                    'img' => $user_data[0]['img'],
                ];
                $request->saveUser($data_ary);
                header('Location: /user/show?update=true');
                exit;
            } else {
                header('Location: /user/show?update=false');
                exit;
            }
        } catch (Exception $e) {
            $errCode = $e->getCode();
            if ($errCode == 23000) {
                $_SESSION['existed_name'] = $display_name;
                header('Location: /user/show');
            } else {
                $_SESSION['existed_name'] = '?';
                header('Location: /user/show');
            }
        }
    }

    protected function after() {
    }
}
