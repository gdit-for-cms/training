<?php

namespace App\Controllers;

use Core\View;
use Core\Http\Request;

class OrderController extends AppController {

    public array $data_ary;

    public function createAction() {
        $this->data_ary['title'] = 'Tạo đơn';
        $this->data_ary['content'] = '/order/create';
    }
}
