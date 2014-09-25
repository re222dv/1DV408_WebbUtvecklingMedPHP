<?php

namespace controller;

require_once('src/view/RegisterView.php');

use model\User;
use view\RegisterView;
use view\UrlView;

class RegisterController {
    /**
     * @var UrlView
     */
    private $url;
    /**
     * @var RegisterView
     */
    private $view;

    public function __construct(UrlView $url) {
        $this->url = $url;
        $this->view = new RegisterView($url);
    }

    public function render() {
        $user = $this->view->getUser();

        if ($user and $user->isValid()) {
            try {
                User::create($user);
                $this->view->setSuccess();
            } catch (\Exception $e) {
                $this->view->setUsernameIsTaken();
            }
        }

        return $this->view->render();
    }
}
