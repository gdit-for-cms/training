<?php

namespace App\Controllers\Admin;

use App\Models\Link;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class LinkController extends AppController
{
    use ResponseTrait;
    public object $obj_file;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_file = new Link;
    }

    // Upload the file to the server and send the uploaded file to js
    public function storeAction(Request $request)
    {
        $post = $request->getPost()->all();
        $results = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["upload-file"])) {
            $targetDir = "file/";
            if(!file_exists($targetDir)){
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . basename($_FILES["upload-file"]["name"]);
        
            // Check if the file already exists
            if (file_exists($targetFile)) {
                $status = false;
                $message = 'File already exists';
            }
            // 
            else if (move_uploaded_file($_FILES["upload-file"]["tmp_name"], $targetFile)) {
                $file_data = [
                    'name' => $post['name-file'],
                    'path' => $targetFile
                ];
                $this->obj_file->create($file_data);
                
                $results = $this->obj_file->getBy('path', '=', $targetFile);
                $status = true;
                $message = 'File uploaded successfully';
            } else {
                $status = false;
                $message = 'Unable to upload file to server';
            }
        } else {
            $status = false;
            $message = 'Something is wrong, please try again!';
        }

        $this->responseFileQuery($status, $message, $results);
    }

    // Delete File
    public function deleteAction(Request $request)
    {
        $file_id = $request->getGet()->get('id');
        $file = $this->obj_file->getById($file_id, '*');

        // Check the file on the server and delete the file
        if (!empty($file['path'])) {
            unlink($file['path']);
        }
        $result = $this->obj_file->destroyBy("id = $file_id");
        if ($result) {
            $status = true;
            $message = 'Delete files success';
        } else {
            $status = false;
            $message = 'Delete files failed';
        }
        return $this->responseFileQuery($status, $message);
    }

    // Update file
    public function updateAction(Request $request)
    {
        $post = $request->getPost()->all();
        $id = $post['properties_id'];

        $result = $this->obj_file->updateOne(
            [
                'name' => $post['properties_name'],
            ],
            "id = $id"
        );

        if ($result) {
            $status = true;
            $message = 'Update file success';
        } else {
            $status = false;
            $message = 'Update file failed';
        }
        return $this->responseFileQuery($status, $message);
    }

    // Search file
    public function searchAction(Request $request)
    {
        $post = $request->getPost()->all();

        $result = $this->obj_file->searchBy($post['input_search'], $post['order']);

        // Returns the page number corresponding to the number of results after searching
        $all_results = $this->obj_file->searchAll($post['input_search']);
        $count_res = count($all_results);
        $qty_page_of_fIle = (int)($count_res / 5);

        if((int)($count_res % 5 != 0)) {
            $qty_page_of_fIle = (int)($count_res / 5) + 1;
        }
        $object = $qty_page_of_fIle;

        return $this->responseFileObj(true, 'Search file success', $result, $object);
    }

    // Load the number of results after searching in a page
    public function qtyofonepageAction(Request $request)
    {
        $post = $request->getPost()->all();

        $qty = (int)$post['qty'];
        $result = $this->obj_file->getByQty($qty, $post['input_search'], $post['desc']);

        $all_results = $this->obj_file->searchAll($post['input_search']);
        $count_res = count($all_results);

        $qty_page_of_fIle = (int)($count_res / $qty);
        if(($count_res % $qty != 0)) {
            $qty_page_of_fIle = (int)($count_res / $qty) + 1;
        }

        $object = $qty_page_of_fIle;

        return $this->responseFileObj(true, 'Change qty file success', $result, $object);
    }

    // Load results when turning pages
    public function paginationAction(Request $request)
    {
        $post = $request->getPost()->all();
        $qty_file_page = (int)$post['qty_file_page'];
        $value_first = ((int)$post['current_page'] - 1) * $qty_file_page;
        $search = $post['input_search'];
        $desc = $post['desc'];

        $result = $this->obj_file->getValueForPaginate($value_first, $qty_file_page, $search, $desc);

        return $this->responseFileQuery(true, 'Change qty file success', $result);
    }

    public function responseFileQuery($status, $message, $result = [])
    {
        $res = [
            "success" => $status,
            "message" => $message,
            "result" => $result,
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }

    public function responseFileObj($status, $message, $result = [], $object)
    {
        $res = [
            "success" => $status,
            "message" => $message,
            "result" => $result,
            "object" => $object,
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }
}
