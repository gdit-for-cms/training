<?php

namespace App\Controllers\Admin;

use App\Models\Link;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\ResponseTrait;
use LDAP\Result;

class LinkController extends AppController
{
    use ResponseTrait;
    public object $obj_file;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_file = new Link;
    }

    public function storeAction(Request $request)
    {
        $post = $request->getPost()->all();
        $files =  $request->getFiles();
        // $targetDir = "/htdocs/training2/training/public/file/";
        // $targetFile = $targetDir . basename($_FILES["upload-file"]["name"]);
        // if (file_exists($targetFile)) {
        //     $this->responseFileQuery(false, 'File already exists', []);
        // }
        
        // // Giới hạn kích thước tệp (vd: giới hạn kích thước 2MB)
        // if ($_FILES["fileToUpload"]["size"] > 2 * 1024 * 1024) {
        //     $this->responseFileQuery(false, 'File size too large', []);
        // }

        // if (move_uploaded_file($_FILES["upload-file"]["tmp_name"], $targetFile)) {
        //     echo "Tệp " . basename($_FILES["upload-file"]["name"]) . " đã được tải lên thành công.";
        // } else {
        //     echo "Có lỗi xảy ra khi tải lên tệp của bạn.";
        // }

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
                    $extension = explode('.', $value['file']['name'])[1];
                    $file_name = rand(10, 1000000) . time() . '.' . $extension;
                    $file_path = '/htdocs/training2/training/public/file/' . $file_name;
                    if (file_exists($file_path)) {
                        $all_results['failed'][$key] = 'File already exists';
                    } else {
                        try {
                            if (move_uploaded_file($value['file']['tmp_name'], $file_path)) {
                                $file_data = [
                                    'name' => $value['name'],
                                    'path' => $file_path
                                ];
                                $result = $this->obj_file->create($file_data);
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

    public function deleteAction(Request $request)
    {
        $file_id = $request->getGet()->get('id');
        $file = $this->obj_file->getById($file_id, '*');
        // if (!empty($file['path'])) {
        //     unlink($file['path']);
        // }
        $result = $this->obj_file->destroyBy("id = $file_id");
        if ($result) {
            return $this->responseFileQuery(true, 'Delete files success', []);
        } else {
            return $this->responseFileQuery(false, 'Delete files failed', []);
        }
    }

    public function loadAction(Request $request)
    {
        $limit = $request->getGet()->get('limit') ? $request->getGet()->get('limit') : 5;
        $get_ary = $request->getGet()->all();
        array_shift($get_ary);
        $result = $this->obj_file->getAllRelation($get_ary, $limit);
        if ($result) {
            return $this->responseFileQuery(true, 'Get link success', $result);
        } else {
            return $this->responseFileQuery(false, 'Get link failed', []);
        }
    }

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

    public function searchAction(Request $request)
    {
        $post = $request->getPost()->all();

        $result = $this->obj_file->searchBy($post['input_search'], $post['order']);

        $all_results = $this->obj_file->searchAll($post['input_search'], $post['order']);
        $qtyPageOfFIle = (int)(count($all_results) / 5);
        if((int)(count($all_results) % 5 != 0)) {
            $qtyPageOfFIle = (int)(count($all_results) / 5) + 1;
        }
        $object = $qtyPageOfFIle;

        return $this->responseFileObj(true, 'Search file success', $result, $object);
    }

    public function qtyofonepageAction(Request $request)
    {
        $post = $request->getPost()->all();

        $qty = (int)$post['qty'];
        $result = $this->obj_file->getByQty($qty, $post['input_search'], $post['desc']);

        $all_results = $this->obj_file->searchAll($post['input_search'], $post['desc']);

        $qtyPageOfFIle = (int)(count($all_results) / $qty);
        if((count($all_results) % $qty != 0)) {
            $qtyPageOfFIle = (int)(count($all_results) / $qty) + 1;
        }

        $object = $qtyPageOfFIle;

        return $this->responseFileObj(true, 'Change qty file success', $result, $object);
    }

    public function paginationAction(Request $request)
    {
        $post = $request->getPost()->all();
        $qty_file_page = (int)$post['qty_file_page'];
        $valueFirst = ((int)$post['current_page'] - 1) * $qty_file_page;
        $search = $post['input_search'];
        $desc = $post['desc'];

        $result = $this->obj_file->getValueForPaginate($valueFirst, $qty_file_page, $search, $desc);

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
