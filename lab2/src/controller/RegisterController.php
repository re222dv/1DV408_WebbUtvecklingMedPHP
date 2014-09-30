<?php

namespace controller;

require_once('src/model/UserRepository.php');
require_once('src/view/RegisterView.php');

use model\UserRepository;
use view\RegisterView;
use view\UrlView;

class RegisterController {
    /**
     * @var UrlView
     */
    private $url;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RegisterView
     */
    private $view;

    public function __construct(UrlView $url, UserRepository $userRepository) {
        $this->url = $url;
        $this->userRepository = $userRepository;
        $this->view = new RegisterView($url);
    }

    public function render() {
        $user = $this->view->getUser();

        if ($user and $user->isValid()) {
            try {
                $this->userRepository->create($user);
                return null;
            } catch (\Exception $e) {
                $this->view->setUsernameIsTaken();
            }
        }

        return $this->view->render();
    }
}
