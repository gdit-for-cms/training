<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\View;

class TableController extends Controller {

    public array $data_ary;

    public $title = 'Create Table';

    public function indexAction() {   
        $this->data_ary['title'] = $this->title;
        $this->data_ary['content'] = 'table/index';
        View::render('admin/table/index.php', $this->data_ary);
    }
}
