<?php

class LoginModel {

	public function checkCredentials(array $credentials) {

		//$username = $credentials['username'];
		//$password = $credentials['password'];
		$username = $credentials[0];
		$password = $credentials[1];

		// Temporary solution
		$userCatalogue = array(
								'Nisse' => 'Pisse',
								'Admin' => 'Password',
								);

		if(array_key_exists($username, $userCatalogue)) {
			if($userCatalogue[$username] == $password) {
				$_SESSION['username'] = $username;
				$_SESSION['isLoggedIn'] = true;
				return true;
			}
			else
				return false;
		}
	}

	public function setLogoutStatus() {
		$_SESSION['isLoggedIn'] = false;
	}

	public function isLoggedIn() {
		if(isset($_SESSION['isLoggedIn']))
			return $_SESSION['isLoggedIn'];
		else
			return false;
	}

	public function getUsername() {
		return $_SESSION['username'];
	}
}