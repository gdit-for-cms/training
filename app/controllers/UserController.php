<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class UserController extends AppController {
    use ResponseTrait;

    public array $data_ary;

    public object $current_user;

    protected function after() {
    }

    public function showAction(Request $request) {
        $current_user = $request->getUser();
        $object_user = new User();
        $user_data = $object_user->getBy('id', '=', $current_user['id']);

        $this->data_ary['user_data'] = $user_data;
        $this->data_ary['content'] = '/user/display';
        View::render('/layouts/master.php', $this->data_ary);
    }

    public function lookupAction(Request $request) {
        $clientId = 'fd7324df-4819-419c-abce-15a87efb7efb'; // Replace with your x-client-id
        $apiKey = '830b441c-7f7c-4609-b61d-cc180ea12936'; // Replace with your x-api-key

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
        // Decode base64 image
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image_data));

        $display_name = $post->get('display_name');
        $bank_bin = $post->get('bank_bin');
        $bank_acc = $post->get('bank_acc');
        $update_data = [
            'img' => $image_data,
            'display_name' => $display_name,
            'bank_bin' => $bank_bin,
            'bank_acc' => $bank_acc
        ];

        $object_user = new User();

        if ($object_user->updateUser($update_data, "id = $current_user_id")) {
            header('Location: /user/show');
            exit;
        }
    }
}
