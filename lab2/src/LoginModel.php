<?php

require_once('src/CredentialsCatalogue.php');

class LoginModel {

	private $credentialsCatalogue;
	private static $usernameLocation = 'username';
	private static $passwordLocation = 'password';
	private static $loginStatusLocation = 'loggedIn';

	public function __construct() {
		$this->credentialsCatalogue = new CredentialsCatalogue();
	}

	public function checkCredentials(array $credentials) {

		$catalogue = $this->credentialsCatalogue->getCatalogue();
		$username = $credentials[0];
		$password = $credentials[1];

		if(array_key_exists($username, $catalogue)) {
			if($catalogue[$username] == $password) {
				$_SESSION[self::$usernameLocation] = $username;
				$_SESSION[self::$loginStatusLocation] = true;
				return true;
			} 
		}

		return false;
	}

	public function setStatusToLogout() {
		$_SESSION[self::$loginStatusLocation] = false;
	}

	public function isLoggedIn() {
		if(isset($_SESSION[self::$loginStatusLocation]))
			return $_SESSION[self::$loginStatusLocation];
		else
			return false;
	}

	public function getUsername() {
		return $_SESSION[self::$usernameLocation];
	}
}