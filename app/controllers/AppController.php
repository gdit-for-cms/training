<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class AppController extends Controller 
{
    
    /**
     * Before filter - called before an action method.
     * 
     * @return title of the action  
     */
    protected function before() {
        if (!checkAdmin()) {
            header('Location: /auth/login');
            exit;
        }
        $this->data['title'] = ucfirst($this->route_params['controller']);
    }
    
    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after() {
        View::render('admin/back-layouts/master.php', $this->data);
    }
}
