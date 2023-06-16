<?php

namespace App\Controllers\Admin;

use App\Models\Image;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ImageController extends AppController
{
    use ResponseTrait;
    public object $obj_image;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_image = new Image;
    }
    public function storeAction(Request $request)
    {
        $post = $request->getPost()->all();
        $files =  $request->getFiles();
        $data_upload = array();
        $all_results = array();
        $add_item_result = [
            'all_results' => [],
            'data_upload' => [],
        ];
        try {
            for ($i = 1; $i <= 5; $i++) {
                $name_key = 'name-file' . $i;
                $file_key = 'upload-photo' . $i;
                $add_item_result = $this->addItemUpload($post[$name_key], $files->get($file_key), $file_key, $add_item_result);
            }
            $data_upload = $add_item_result['data_upload'];
            $all_results = $add_item_result['all_results'];

            if (!empty($data_upload)) {
                foreach ($data_upload as $key => $value) {
                    $extension = explode('.', $value['file']['name'])[1];
                    $file_name = rand(10, 1000000) . time() . '.' . $extension;
                    $file_path = 'images/library_images/' . $file_name;
                    if (file_exists($file_path)) {
                        $all_results['failed'][$key] = 'File already exists';
                    } else {
                        try {
                            if (move_uploaded_file($value['file']['tmp_name'], $file_path)) {
                                $file_data = [
                                    'name' => $value['name'],
                                    'path' => $file_path
                                ];
                                $result = $this->obj_image->create($file_data);
                                if ($result) {
                                    $all_results['success'][$key] = 'Uploaded!';
                                    $get_data_from_db = $this->obj_image->getBy('path', '=', $file_path);
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
                $count_success = count($all_results['success']);
                if ($count_success == 5) {
                    $this->responseUpload(true, 'All image uploaded!', $all_results);
                } else {
                    $this->responseUpload(true, $count_success . ' image uploaded  success', $all_results);
                }
            } else {
                $this->responseUpload(false, 'Select image, enter name and try again!');
            }
        } catch (\Throwable $th) {
            $this->responseUpload(false, 'Something wrong! Select image and try again!');
        }
    }

    public function addItemUpload($name, $file, $file_key, $add_item_result)
    {
        if (!empty($name) && ($file['size'] > 0)) {
            if ($file['size'] < 10000000) {
                $add_item_result['data_upload'][$file_key] = [
                    'name' => $name,
                    'file' => $file
                ];
            } else {
                $add_item_result['all_results']['failed'][$file_key] = 'File too large!';
            }
        } else {
            $add_item_result['all_results']['failed'][$file_key] = 'Check name, size!';
        }
        return $add_item_result;
    }
    public function responseUpload($status, $message, $result = [])
    {
        $res = [
            "success" => $status,
            "message" => $message,
            "result" => $result
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }
}
