<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\View;

class AppController extends Controller {   
    protected function before() {
        if (!checkAdmin()) {
            header('Location: /admin/auth/login');
            exit;
        }
        $this->data_ary['title'] = $this->title;
    }
    
    protected function after() {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }
}
