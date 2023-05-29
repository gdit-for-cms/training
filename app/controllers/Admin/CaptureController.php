<?php

namespace App\Controllers\Admin;

use App\Requests\AppRequest;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class CaptureController extends AppController
{
    use ResponseTrait;

    public $title = 'Page Capture';


    public array $data_ary;

    public function __construct()
    {
    }

    public function indexAction(Request $request)
    {
        $this->data_ary['content'] = 'capture-page/index';
    }
    public function capturePageAction(Request $request)
    {
        $url = $request->getPost()->get('url');
        // get webpage url
        $url = $_POST['url'];
        $googleApiKey = "AIzaSyAr1LBQHvEtGn0qv4vbY13q5hS_0xO44-w";

        // check if it is a valid url
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // send request to api
            $data = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&key=$googleApiKey&screenshot=true");
            $data = json_decode($data, true);
            $screenshot = $data['lighthouseResult']['fullPageScreenshot']['screenshot']['data'];
            $path = 'images/screenshots';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $this->saveBase64ImagePng($screenshot, $path);
            $this->data_ary['screenshot'] = $screenshot;
            $this->data_ary['url'] = $url;
            $this->data_ary['content'] = 'capture-page/index';
        } else {
            $err = "Please enter a valid URL!";
        }
    }
    function saveBase64ImagePng($base64Image, $imageDir)
    {
        $base64Image = trim($base64Image);
        $base64Image = explode(',', $base64Image);
        $imageData = base64_decode($base64Image[1]);
        $fileName = uniqid() . date("Y-m-d-H-i-s") . ".png";
        $filePath = $imageDir . '/' . $fileName;
        file_put_contents($filePath, $imageData);
    }
}
