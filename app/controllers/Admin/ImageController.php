<?php

namespace App\Controllers\Admin;

use App\Models\Image;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class RuleController extends AppController
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
        $post_request = $request->getPost()->all();
        return json_encode($post_request);
    }
}
