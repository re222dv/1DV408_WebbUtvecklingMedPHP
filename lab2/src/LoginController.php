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

	// Reagera på användaren, programmstarter, ingen get, html
	public function doLogin() {

		// If user has clicked on LOGIN-button
		if($this->loginView->didUserLogin()) {
			
			if($this->loginView->isValidInput()) {

				if($this->loginModel->checkCredentials($this->loginView->getCredentials()))
					$this->loginView->setLoginMessage();
				else
					$this->loginView->setFailMessage();
			}
		}

		// If user ha clicked on LOGOUT-button
		if($this->loginView->didUserLogout()) {
			//Ändrar loginstatus på modell
			$this->loginModel->setLogoutStatus();
			$this->loginView->setLogoutMessage();
		}

		// TODO if rememberMe cookie is set

		// Check login-status and show appropriate html.
		if($this->loginModel->isLoggedIn())
			return $this->loginView->getHTMLLogout();	
		else
			return $this->loginView->getHTMLLogin();
	}
}