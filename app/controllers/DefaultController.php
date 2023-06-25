<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class DefaultController extends Controller {
    public array $data_ary;

    public $title = 'default';
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {
        $this->data_ary['title']   = $this->title;
        $this->data_ary['content'] = 'admin/dashboard';
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }
}