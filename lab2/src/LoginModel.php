<?php

require_once('src/CredentialsCatalogue.php');

class LoginModel {

	private $credentialsCatalogue;
	//TEMP
	//private $userAgent;

	public function __construct() {
		$this->credentialsCatalogue = new CredentialsCatalogue();
	}

	public function checkCredentials(array $credentials) {

		$catalogue = $this->credentialsCatalogue->getCatalogue();
		$username = $credentials[0];
		$password = $credentials[1];

		if(array_key_exists($username, $catalogue)) {
			if($catalogue[$username] == $password) {
				$_SESSION['username'] = $username;
				$_SESSION['isLoggedIn'] = true;
				return true;
			} else {
				return false;
			}
		}
	}

	public function setStatusToLogout() {
		$_SESSION['isLoggedIn'] = false;
	}

	public function isLoggedIn() {
		if(isset($_SESSION['isLoggedIn'])/* && $this->isValidSession()*/)
			return $_SESSION['isLoggedIn'];
		else
			return false;
	}

	public function getUsername() {
		return $_SESSION['username'];
	}
}