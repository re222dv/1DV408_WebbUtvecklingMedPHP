<?php

namespace controller;

require_once('src/model/LoginModel.php');
require_once('src/model/UserControl.php');
require_once('src/view/LoginView.php');
require_once('src/view/CredentialsHandler.php');

use model\LoginModel;
use model\UserControl;
use model\UserRepository;
use view\CredentialsHandler;
use view\LoginView;
use view\UrlView;

class LoginController {

    private $loginModel;
    private $loginView;
    private $userControl;
    private $credentialsHandler;

    public function __construct(UrlView $url, UserRepository $userRepository) {
        $this->loginModel = new LoginModel($userRepository);
        $this->userControl = new UserControl();
        $this->credentialsHandler = new CredentialsHandler();
        $this->loginView = new LoginView($this->loginModel, $url);
    }

    // Login execution flow
    public function doLogin() {
        if ($this->userControl->checkUserAgent($this->loginView->getUserAgent())) {
            if ($this->loginModel->isLoggedIn()) {
                if ($this->loginView->didUserLogout()) {
                    $this->logout();
                }
            } else {
                if ($this->credentialsHandler->cookieExist()) {
                    $this->cookieLogin();
                } else {
                    if ($this->loginView->didUserLogin()) {
                        $this->login();
                    }
                }
            }

            return $this->getHTML();
        }

        return $this->loginView->getLoginHTML();
    }

    // Handles the process of logging out
    private function logout() {
        $this->loginModel->logOut();
        $this->credentialsHandler->clearCredentials();
        $this->loginView->setLogoutMessage();
    }

    // Handles the process of logging in
    private function login() {
        if ($this->loginView->hasValidInput()) {
            $username = $this->loginView->getUsername();
            $password = $this->loginView->getPassword();
            if ($this->loginModel->logIn($username, $password)) {
                if ($this->loginView->doRememberMe()) {
                    $this->credentialsHandler->saveCredentials($this->loginModel->getUser());
                    $this->loginView->setRememberMeLoginMessage();
                } else {
                    $this->loginView->setLoginMessage();
                }
            } else {
                $this->loginView->setFailMessage();
            }
        }
    }

    // Handles the process of logging in with cookies
    private function cookieLogin() {
        try {
            $token = $this->credentialsHandler->getCredentials();
            $this->loginModel->logInByToken($token);
            $this->loginView->setCookieLoginMessage();
        } catch (\Exception $e) {
            $this->credentialsHandler->clearCredentials();
            $this->loginView->setFaultyCookieMessage();
        }
    }

    // Return appropriate HTML depending on if user is logged in or not
    private function getHTML() {
        if ($this->loginModel->isLoggedIn()) {
            return $this->loginView->getLogoutHTML();
        } else {
            return $this->loginView->getLoginHTML();
        }
    }

    public function setRegisterSuccess() {
        $this->loginView->setRegisterSuccess();
    }
}
