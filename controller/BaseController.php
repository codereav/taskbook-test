<?php

namespace App\Controller;

use App\System\Application;

abstract class BaseController
{
    protected $isLogged = false;
    protected $view;
    protected $data = [];

    public function __construct()
    {
        $app = Application::getInstance();
        if ($app->getAuth()->isLoggedIn()) {
            $this->isLogged = true;
        }
        $this->view = $app->getView();
        $this->data['baseUrl'] = $app->getBaseUrl();
        $this->data['isLogged'] = $app->getAuth()->isLoggedIn();
    }

}