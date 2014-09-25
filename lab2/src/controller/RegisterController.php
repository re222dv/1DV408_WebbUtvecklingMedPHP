<?php

namespace controller;

require_once('src/view/RegisterView.php');

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
        return $this->view->render();
    }
}
