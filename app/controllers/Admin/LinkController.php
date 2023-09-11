<?php

namespace App\Controllers\Admin;

use App\Models\Link;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use Core\Http\Config;

class LinkController extends AppController
{
    use ResponseTrait;
    use Config;

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
        $message = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_FILES["upload-file"]['error'] == 0 && $post['name-file'] != null) {
            // Check if the folder is there
            $target_dir = "file/";
            if(!file_exists($target_dir)){
                mkdir($target_dir, 0777, true);
            } else {
                chmod($target_dir, 0777);
            }

            // Get the file extension being uploaded
            $file_extension = pathinfo($_FILES["upload-file"]['name'], PATHINFO_EXTENSION);

            $target_file = $target_dir . basename($_FILES["upload-file"]["name"]);
            
            // Check file type
            if(!in_array($file_extension, $this->allowed_extensions)) {
                $status = false;
                $message = 'The file must be in one of the following formats: ' . implode(', ', $this->allowed_extensions);
            } 
            //  Check file size
            else if($_FILES["upload-file"]["size"] > $this->max_size) {
                $status = false;
                $message = 'File size too large! The maximum file size is 5MB.';
            } 
            // Check if the file already exists
            else if (file_exists($target_file)) {
                $status = false;
                $message = 'File already exists! Do you want to REPLACE it with a new file?';
            }
            // Upload files to the server
            else if (move_uploaded_file($_FILES["upload-file"]["tmp_name"], $target_file)) {
                $file_data = [
                    'name' => $post['name-file'],
                    'path' => '/' . $target_file
                ];
                $this->obj_file->create($file_data);
                
                $results = $this->obj_file->searchBy('', 'descending');
                $status = true;
                $message = 'File uploaded successfully!';
            } else {
                $status = false;
                $message = 'Unable to upload file to server!';
            }
        } else {
            $status = false;
            $message = 'You must enter a file name and file, try again!';
        }

        return $this->responseFileQuery($status, $message, $results);
    }

    public function uploadAction(Request $request)
    {
        $post = $request->getPost()->all();
        $results = array();
        $message = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_FILES["upload-file"]['error'] == 0 && $post['name-file'] != null) {
            // Check if the folder is there
            $target_dir = "file/";
            if(!file_exists($target_dir)){
                mkdir($target_dir, 0777, true);
            } else {
                chmod($target_dir, 0777);
            }

            $target_file = $target_dir . basename($_FILES["upload-file"]["name"]);
            if (!empty($target_file)) {
                unlink($target_file);
            }
            // var_dump($this->obj_file->destroyBy("path = '$target_file'"));
            $this->obj_file->destroyBy("path = '/$target_file'");

            if (move_uploaded_file($_FILES["upload-file"]["tmp_name"], $target_file)) {
                $file_data = [
                    'name' => $post['name-file'],
                    'path' => '/' . $target_file
                ];
                $this->obj_file->create($file_data);
                
                $results = $this->obj_file->searchBy('', 'descending');
                $status = true;
                $message = 'File uploaded successfully!';
            } else {
                $status = false;
                $message = 'Unable to upload file to server!';
            }
        } else {
            $status = false;
            $message = 'You must enter a file name and file, try again!';
        }

        return $this->responseFileQuery($status, $message, $results);
    }

    // Delete File
    public function deleteAction(Request $request)
    {
        $file_id = $request->getGet()->get('id');

        $current_page = (int)($request->getGet()->get('current_page'));
        $qty_file_page = (int)($request->getGet()->get('qty_file_page'));
        $input_search = $request->getGet()->get('input_search');
        $desc = $request->getGet()->get('desc');

        

        $file = $this->obj_file->getById($file_id, '*');
        
        // Check the file on the server and delete the file
        if (!empty($file['path'])) {
            unlink($file['path']);
        }
        $result = $this->obj_file->destroyBy("id = $file_id");
        if ($result) {
            $value_first = ($current_page - 1) * $qty_file_page;

            $results = $this->obj_file->getValueForPaginate($value_first, $qty_file_page, $input_search, $desc);

            $status = true;
            $message = 'Delete files success';
        } else {
            $status = false;
            $message = 'Delete files failed';
        }
        return $this->responseFileQuery($status, $message, $results);
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

    public function totalPagesAction()
    {
        $all_results = $this->obj_file->getAll();

        $count = count($all_results);

        $total_page = (int)($count / 5);

        if(($count % 5 != 0)) {
            $total_page = (int)($count / 5) + 1;

        }
        return $this->responseFileQuery(true, '', $total_page);
    }
}
