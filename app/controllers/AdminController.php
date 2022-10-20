<?php

namespace App\Controllers;

class AdminController extends AppController
{
    public array $data;

    public function indexAction()
    {   
        $this->data['content'] = 'admin/dashboard';
    }
}
