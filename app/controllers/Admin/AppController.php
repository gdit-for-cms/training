<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Http\Request;
use Core\View;

class AppController extends Controller
{
    public $title = 'App';

    public array $data_ary;

    protected function before()
    {
        if (!checkAuth()) {
            header('Location: /admin/auth/login');
            exit;
        }
        if (!checkPermission()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $this->data_ary['title'] = $this->title;
    }


    protected function after()
    {
        View::render('admin/back-layouts/master.php', $this->data_ary);
    }
}
