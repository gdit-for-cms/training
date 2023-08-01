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
        $files =  $request->getFiles();

        $data_upload = array();
        $all_results = array();
        $add_item_result = [
            'all_results' => array(),
            'data_upload' => array(),
        ];
        try { 
            $name_key = 'name-file';
            $file_key = 'upload-file';
            $add_item_result = $this->addItemUpload($post[$name_key], $files->get($file_key), $file_key, $add_item_result);
            $data_upload = $add_item_result['data_upload'];
            $all_results = $add_item_result['all_results'];
            
            if (!empty($data_upload)) {
                foreach ($data_upload as $key => $value) {
                    $file_name = $value['file']['name'];
                    $file_path = '/htdocs/training2/training/public/file/' . $file_name;
                    if (file_exists($file_path)) {
                        $all_results['failed'][$key] = 'File already exists';
                    } else {
                        try {
                            // Upload files to the server
                            if (move_uploaded_file($value['file']['tmp_name'], $file_path)) {
                                $file_data = [
                                    'name' => $value['name'],
                                    'path' => $file_path
                                ];
                                $result = $this->obj_file->create($file_data);

                                // Send files outside js
                                if ($result) {
                                    $all_results['success'][$key] = 'Uploaded!';
                                    $get_data_from_db = $this->obj_file->getBy('path', '=', $file_path);
                                    if ($get_data_from_db) {
                                        $all_results['new_images'][$key] = $get_data_from_db;
                                    }
                                } else {
                                    unlink($file_path);
                                    $all_results['failed'][$key] = 'Failed!';
                                }
                            } else {
                                $all_results['failed'][$key] = 'Failed!';
                            }
                        } catch (\Throwable $th) {
                            $all_results['failed'][$key] = 'Failed!';
                        }
                    }
                }
                    $this->responseFileQuery(true, 'All file uploaded!', $all_results);
            } else {
                $this->responseFileQuery(false, 'Filename and path cannot be empty, try again!', $all_results);
            }
        } catch (\Throwable $th) {
            $this->responseFileQuery(false, 'Something wrong! Select file and try again!');
        }
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
            return $this->responseFileQuery(true, 'Delete files success', []);
        } else {
            return $this->responseFileQuery(false, 'Delete files failed', []);
        }
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
            return $this->responseFileQuery(true, 'Update file success', $result);
        } else {
            return $this->responseFileQuery(false, 'Update file failed', []);
        }
    }

    // Search file
    public function searchAction(Request $request)
    {
        $post = $request->getPost()->all();

        $result = $this->obj_file->searchBy($post['input_search'], $post['order']);

        // Returns the page number corresponding to the number of results after searching
        $all_results = $this->obj_file->searchAll($post['input_search'], $post['order']);
        $qty_page_of_fIle = (int)(count($all_results) / 5);
        if((int)(count($all_results) % 5 != 0)) {
            $qty_page_of_fIle = (int)(count($all_results) / 5) + 1;
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

        $all_results = $this->obj_file->searchAll($post['input_search'], $post['desc']);

        $qty_page_of_fIle = (int)(count($all_results) / $qty);
        if((count($all_results) % $qty != 0)) {
            $qty_page_of_fIle = (int)(count($all_results) / $qty) + 1;
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

    public function addItemUpload($name, $file, $file_key, $add_item_result)
    {
        if (!empty($name) && ($file['size'] > 0)) {
            if ($file['size'] < 4000000) {
                $add_item_result['data_upload'][$file_key] = [
                    'name' => $name,
                    'file' => $file
                ];
            } else {
                $add_item_result['all_results']['failed'][$file_key] = 'File too large!';
            }
        } else {
            $add_item_result['all_results']['failed'][$file_key] = 'Please enter name input and select image file!';
        }
        return $add_item_result;
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
