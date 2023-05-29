<?php

namespace App\Controllers\Admin;

use App\models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use JonnyW\PhantomJs\Client;

class PhantomjsController extends AppController
{
    use ResponseTrait;

    public $title = 'Phantomjs';

    public object $obj_model;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_model = new User;
    }

    public function indexAction()
    {
        $this->data_ary['content'] = 'phantomjs/index';
    }

    public function screen(Request $request)
    {
        $this->data_ary['content'] = 'phantomjs/index';

        $url = $request->getPost()->get('url');
        $client = Client::getInstance();

        // Update Path 
        $client->getEngine()->setPath('/phantomjs-2.1.1-linux-x86_64/bin/phantomjs');

        /** 
         * @see JonnyW\PhantomJs\Http\Request
         **/
        $request = $client->getMessageFactory()->createRequest($url, 'GET');

        /** 
         * @see JonnyW\PhantomJs\Http\Response 
         **/
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        if ($response->getStatus() === 200) {
            // Dump the requested page content
            echo $response->getContent();
            return $this->successResponse($this->data_ary, 'Screenshot successfully.');
        } else {
            echo 'Error';
        }
    }

    public function saving(Request $request)
    {
        $this->data_ary['content'] = 'phantomjs/index';

        $url = $request->getPost()->get('url');

        $client = Client::getInstance();

        // Update Path 
        $client->getEngine()->setPath('/phantomjs-2.1.1-linux-x86_64/bin/phantomjs');

        $width  = 1200;
        $height = 600;
        // $top    = 0;
        // $left   = 0;

        /** 
         * @see JonnyW\PhantomJs\Http\CaptureRequest
         **/

        $request = $client->getMessageFactory()->createCaptureRequest($url, 'GET');

        // Check path save
        $path = '/public/img/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $request->setOutputFile('/public/img/' . rand(1, 10000) . '.jpeg');
        $request->setViewportSize($width, $height);
        // $request->setCaptureDimensions($width, $height, $top, $left);

        /** 
         * @see JonnyW\PhantomJs\Http\Response 
         **/
        $response = $client->getMessageFactory()->createResponse();
        // Send the request
        $client->send($request, $response);
        return $this->successResponse($this->data_ary, 'Save image successfully.');
    }

    public function outputting(Request $request)
    {
        $this->data_ary['content'] = 'phantomjs/index';

        $url = $request->getPost()->get('url');

        $client = Client::getInstance();

        // Update Path 
        $client->getEngine()->setPath('/phantomjs-2.1.1-linux-x86_64/bin/phantomjs');

        /** 
         * @see JonnyW\PhantomJs\Http\PdfRequest
         **/
        $request = $client->getMessageFactory()->createPdfRequest($url, 'GET');

        // Check path save
        $path = '/public/img/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $request->setOutputFile('/public/img/' . rand(1, 10000) . '.pdf');
        $request->setFormat('A4');
        $request->setOrientation('landscape');
        $request->setMargin('1cm');

        /** 
         * @see JonnyW\PhantomJs\Http\Response 
         **/
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);
        return $this->successResponse($this->data_ary, 'Export PDF file successfully.');
    }
}
