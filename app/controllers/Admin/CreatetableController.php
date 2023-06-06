<?php

namespace App\Controllers\Admin;

use App\Requests\AppRequest;
use App\Models\Position;
use App\models\User;
use App\models\Role;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class CreatetableController extends AppController {
    use ResponseTrait;

    public $title = 'Tạo bảng bằng HTML, JS';

    public object $obj_model;
    
    public array $data_ary;

    public function __construct() {
        $this->obj_model = new User;
    }

    public function indexAction(Request $request) {   
        $this->data_ary['content'] = 'create-table/index';
    }
}
