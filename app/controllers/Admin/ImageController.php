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
        for ($i = 1; $i <= 5; $i++) {
            $name_key = 'name-file' . $i;
            $file_key = 'upload-photo' . $i;
            $data_upload = $this->addItemUpload($data_upload, $post[$name_key], $files->get($file_key));
        }

        if (!empty($data_upload)) {
            foreach ($data_upload as $key => $value) {
                $file_name = time() . $value['name'];
                $path = "images/library_images/" . $file_name;

                if (move_uploaded_file($value['tmp_name'], $path)) {
                    $this->obj_image->create(
                        [
                            'name' => $key,
                            'path' => $path
                        ]
                    );
                }
            }
        }
        echo json_encode($data_upload);
    }

    public function addItemUpload($data_upload, $name, $file)
    {
        if (!empty($name) && ($file['size'] > 0)) {
            $data_upload[$name] = $file;
        }
        return $data_upload;
    }
}
