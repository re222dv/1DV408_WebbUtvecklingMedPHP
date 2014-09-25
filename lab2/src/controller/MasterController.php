<?php

namespace controller;

require_once('src/controller/LoginController.php');
require_once('src/controller/RegisterController.php');
require_once('src/view/UrlView.php');

use view\UrlView;

class MasterController {
    /**
     * @var UrlView
     */
    private $url;
    /**
     * @var LoginController
     */
    private $login;
    /**
     * @var RegisterController
     */
    private $register;

    public function __construct() {
        $this->url = new UrlView();
        $this->login = new LoginController($this->url);
        $this->register = new RegisterController($this->url);
    }

    public function render() {
        if ($this->url->isLogin()) {
            return $this->login->doLogin();

        } elseif ($this->url->isRegister()) {
            return $this->register->render();

        } else {
            throw new \Exception(404);
        }
    }
}
