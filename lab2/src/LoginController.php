<?php

require_once('src/LoginModel.php');
require_once('src/SessionChecker.php');
require_once('src/LoginView.php');
require_once('src/CredentialsCookieHandler.php');

class LoginController {

	private $loginModel;
	private $loginView;
	private $sessionChecker;
	private $credentialsCookieHandler;

	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->sessionChecker = new SessionChecker();
		$this->credentialsCookieHandler = new CredentialsCookieHandler();
		$this->loginView = new LoginView($this->loginModel);
	}

	public function doLogin() {

		//$this->sessionChecker->setUserAgent($this->loginView->getUserAgent());

		if($this->loginModel->isLoggedIn()/* && $this->sessionChecker->checkUserAgent($this->loginView->getUserAgent())*/) {
			//var_dump($_SESSION);
			//var_dump($this->sessionCheck->getValidUserAgent());
			//die();
			if($this->loginView->didUserLogout())
				$this->logout();
		} else {
			if($this->credentialsCookieHandler->exists()){
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
		$this->credentialsCookieHandler->removeCookies();
		$this->loginView->setLogoutMessage();
	}

	private function login() {
		if($this->loginView->hasValidInput()) {
			if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
				if($this->loginView->doRememberMe()) {
					$this->credentialsCookieHandler->saveUserCredentials($this->loginView->getCredentials());
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
		// Spara inte lösenord i klartext

		if($this->credentialsCookieHandler->isValidCookies()
		&& $this->loginModel->checkCredentials($this->credentialsCookieHandler->getCredentials())) {
			$this->loginView->setCookieLoginMessage();
		} else {
			$this->credentialsCookieHandler->removeCookies();
			$this->loginView->setFaultyCookieMessage();
		}

		$this->loginView->reloadPage();
	}

	private function getHTML() {
		if($this->loginModel->isLoggedIn()/* && $this->sessionChecker->checkUserAgent($this->loginView->getUserAgent())*/)
			return $this->loginView->getLogoutHTML();	
		else
			return $this->loginView->getLoginHTML();
	}
}