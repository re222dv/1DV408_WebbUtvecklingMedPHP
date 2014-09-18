<?php

require_once('src/LoginModel.php');
require_once('src/UserControl.php');
require_once('src/LoginView.php');
require_once('src/CredentialsHandler.php');

class LoginController {

	private $loginModel;
	private $loginView;
	private $userControl;
	private $credentialsHandler;

	public function __construct() {
		
		$this->loginModel = new LoginModel();
		$this->userControl = new UserControl();
		$this->credentialsHandler = new CredentialsHandler();
		$this->loginView = new LoginView($this->loginModel);
	}

	public function doLogin() {

		if($this->userControl->checkUserAgent($this->loginView->getUserAgent())) {
			if($this->loginModel->isLoggedIn()) {
				if($this->loginView->didUserLogout())
					$this->logout();
			} else {
				if($this->credentialsHandler->cookieExist()){
					$this->cookieLogin();
				} else {
					if($this->loginView->didUserLogin()) {
						$this->login();
					}
				}
			}

			return $this->getHTML();
		}

		$this->loginView->setIllegalSessionMessage();

		return $this->loginView->getLoginHTML();
	}

	private function logout() {

		$this->loginModel->setStatusToLogout();
		$this->credentialsHandler->clearCredentials();
		$this->loginView->setLogoutMessage();
	}

	private function login() {

		if($this->loginView->hasValidInput()) {
			if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
				if($this->loginView->doRememberMe()) {
					$this->credentialsHandler->saveCredentials($this->loginView->getCredentials());
					$this->loginView->setRemberMeLoginMessage();
				} else {
					$this->loginView->setLoginMessage();
				}
			} else {
				$this->loginView->setFailMessage();
			}
		}
	}

	private function cookieLogin() {

		if($this->credentialsHandler->isValidCookies()
		&& $this->loginModel->checkCredentials($this->credentialsHandler->getCredentials())) {
			$this->loginView->setCookieLoginMessage();
		} else {
			$this->credentialsHandler->clearCredentials();
			$this->loginView->setFaultyCookieMessage();
		}
	}

	private function getHTML() {

		if($this->loginModel->isLoggedIn())
			return $this->loginView->getLogoutHTML();	
		else
			return $this->loginView->getLoginHTML();
	}
}