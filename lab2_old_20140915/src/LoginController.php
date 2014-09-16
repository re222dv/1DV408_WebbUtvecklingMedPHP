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


		/*

		30-31 min
		Hantera indata

		Fråga modellen om inloggad
		Om inloggad
			Fråga vyn om användaren vill logga ut
			Om Ja så berätta för modellen att användaren vill logga ut

		Om inte inloggad
			Fråga vyn om användaren vill logga in
			Om JA så be vyn om användaruppgifter
				Fråga modellen om det gicka bra att logga in
				Berätta för vyn om det gick bra eller inte
	
			Om NEJ så är tillståndet oförändrat


		Generera utdata med vyn

		*/

		// Is user logged in
		if($this->loginModel->isLoggedIn()) {
			if($this->loginView->didUserLogout()) {
				$this->loginModel->setLogoutStatus();
				$this->loginView->setLogoutMessage();
			}
		} else {
			
			if($this->loginView->cookiesExist()){
					if($this->loginModel->checkCredentials($this->loginView->readUserCookies())) {
						$this->loginView->setCookieLoginMessage();
						$this->loginView->reloadPage();
					}
			} else {
				if($this->loginView->didUserLogin()) {
					if($this->loginView->isValidInput()) {
						if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
							if($this->loginView->doRememberMe()) {// Remember me
								//TEMP
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
			}
		}

		// Show appropriate html.
		if($this->loginModel->isLoggedIn())
			return $this->loginView->getHTMLLogout();	
		else
			return $this->loginView->getHTMLLogin();














/*

		// TODO if rememberMe cookie is set
		if($this->loginModel->isLoggedIn() == false){
			if($this->loginView->cookiesExist()){
				if($this->loginModel->checkCredentials($this->loginView->readUserCookies())) {
					$this->loginView->setCookieLoginMessage();
					$this->loginView->reloadPage();
				}
			}
		}





		// If user has clicked on LOGIN-button
		if($this->loginView->didUserLogin()) {
			
			if($this->loginView->isValidInput()) {

				if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
					if($this->loginView->doRememberMe()) {// Remember me
						//TEMP
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

		// If user ha clicked on LOGOUT-button
		if($this->loginView->didUserLogout()) {
			// Ta bort eventuella userkakor
				$this->loginView->removeUserCookies();
			//Ändrar loginstatus på modell
			$this->loginModel->setLogoutStatus();
			$this->loginView->setLogoutMessage();
		}

		// Check login-status and show appropriate html.
		if($this->loginModel->isLoggedIn())
			return $this->loginView->getHTMLLogout();	
		else
			return $this->loginView->getHTMLLogin();


*/
	}
}