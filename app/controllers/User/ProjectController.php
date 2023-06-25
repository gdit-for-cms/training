<?php

namespace App\Controllers\Project;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class ProjectController extends Controller {
    use ResponseTrait;
    public array $data;

    protected function before() {
        if (!isLogged()) {
            header('Location: /');
            exit;
        }

        if (!checkAccess($this->route_params['controller'])) {
            header('Location: /');
            exit;
        }

        $this->data['title'] = 'Homepage';
    }

    protected function after() {
        View::render('homepage/front-layouts/master.php', $this->data);
    }

    public function homepageAction() {
        $this->data['content'] = 'home/homepage';
    }
}