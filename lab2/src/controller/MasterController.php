<?php

namespace controller;

require_once('src/controller/LoginController.php');
require_once('src/controller/RegisterController.php');
require_once('src/model/UserRepository.php');
require_once('src/view/UrlView.php');

use model\UserRepository;
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
        $userRepository = new UserRepository();

        $this->url = new UrlView();
        $this->login = new LoginController($this->url, $userRepository);
        $this->register = new RegisterController($this->url, $userRepository);
    }

    public function render() {
        if ($this->url->isLogin()) {
            return $this->login->doLogin();

        } elseif ($this->url->isRegister()) {
            $view = $this->register->render();
            if ($view) {
                return $view;
            }

            $this->login->setRegisterSuccess();
            return $this->login->doLogin();
        } else {
            throw new \Exception(404);
        }
    }
}
