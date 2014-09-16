<?php

require_once('src/LoginModel.php');
require_once('src/LoginView.php');

class LoginController {

	private $loginModel;
	private $loginView;

	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->loginView = new LoginView($this->loginModel);
	}

	public function doLogin() {
		if($this->loginModel->isLoggedIn()) {
			if($this->loginView->didUserLogout())
				$this->logout();
		} else {
			if($this->loginView->cookiesExist()){
				$this->cookieLogin();
			} else {
				if($this->loginView->didUserLogin()) {
					$this->login();
				}
			}
		}
		
		$this->loginView->reloadAfterPOST();
		
		return $this->getHTML();
	}

	private function logout() {
		$this->loginModel->setStatusToLogout();
		$this->loginView->removeCredentialsCookie();
		$this->loginView->setLogoutMessage();
	}

	private function login() {
		if($this->loginView->hasValidInput()) {
			if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
				if($this->loginView->doRememberMe()) {
					$this->loginView->saveCredentials();
					$this->loginView->setRemberMeLoginMessage();
				} else {
					$this->loginView->setLoginMessage();
				}
			}
			else
				$this->loginView->setFailMessage();
		}
	}

	private function cookieLogin() {
		if($this->loginModel->checkCredentials($this->loginView->readCredentialsCookie())) {
			$this->loginView->setCookieLoginMessage();
			$this->loginView->reloadPage();
		}
	}

	private function getHTML() {
		if($this->loginModel->isLoggedIn())
			return $this->loginView->getLogoutHTML();	
		else
			return $this->loginView->getLoginHTML();
	}
}