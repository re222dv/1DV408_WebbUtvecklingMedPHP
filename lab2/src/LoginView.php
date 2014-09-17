<?php

require_once('src/CookieHandler.php');

class LoginView {

	private $loginModel;
	private $messageCookie;
	private $inputCookie;

	public function __construct($loginModel) {
		$this->loginModel = $loginModel;
		$this->messageCookie = new CookieHandler('message');
		$this->inputCookie = new CookieHandler('input');
	}

	public function didUserLogin() {
		if(isset($_POST['login']))
			return true;
		else
			return false;
	}

	public function didUserLogout() {
		if(isset($_POST['logout']))
			return true;
		else
			return false;
	}

	public function hasValidInput() {
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			return true;
		} elseif(empty($_POST['username'])) {
			$this->messageCookie->save('Användarnamn saknas');
		} else {
			$this->messageCookie->save('Lösenord saknas');
		}
	}

	public function getCredentials() {
		return array($_POST['username'], $_POST['password']);
	}

	public function setRemberMeLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades och vi kommer ihåg dig nästa gång');
	}

	public function setLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades');
	}

	public function setFailMessage() {
		$this->messageCookie->save('Felaktigt användarnamn och/eller lösenord');
	}

	public function setLogoutMessage() {
		$this->messageCookie->save('Du har nu loggat ut');
	}

	public function setCookieLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades via cookies');
	}

	public function setFaultyCookieMessage() {
		$this->messageCookie->save('Felaktig information i cookie');
	}

	public function doRememberMe() {
		if(isset($_POST['rememberMe']))
			return true;
		else
			return false;
	}

	// Pagereload

	public function reloadPage() {
		header('Location: ' . $_SERVER['PHP_SELF']);
	}

	public function reloadAfterPOST() {
		if($_SERVER['REQUEST_METHOD'] == 'POST')
			$this->reloadPage();
	}
	
	// Session - Useragent
	
	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	// HTML output

	public function getLoginHTML() {

		$output = '
			<h2>Ej inloggad</h2>
			<form action="' . $_SERVER["PHP_SELF"] .' " method="post">
				<fieldset>
					<legend>Login</legend>';

		if($this->messageCookie->exists())
			$output .= '<p>' . $this->messageCookie->load() . '</p>';				

		$output .= '
					<label>Användarnamn
						<input type="text" name="username"';

		if($this->inputCookie->exists())
			$output .= ' value="' . $this->inputCookie->load() . '"';

		if(isset($_POST['username']))
			$this->inputCookie->save($_POST['username']);

		$output .= '/>
					</label>
					
					<label>Lösenord
						<input type="password" name="password"/>
					</label>

					<label>
						<input type="checkbox" name="rememberMe"/>
						Håll mig inloggad
					</label>
			
					<input type="submit" name="login" value="Logga in"/>
				</fieldset>
			</form>';
		
		return $output;
	}

	public function getLogoutHTML() {

		$output = '<h2>' . $this->loginModel->getUsername() . ' är inloggad</h2>';

		$output .= '
			<form action="' . $_SERVER["PHP_SELF"] .' " method="post">';
				
		if($this->messageCookie->exists())
			$output .= '<p>' . $this->messageCookie->load() . '</p>';	

		$output .= '
				<input type="submit" name="logout" value="Logga ut"/>
			</form>';

		return $output;
	}
}