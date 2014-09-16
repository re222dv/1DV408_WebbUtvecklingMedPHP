<?php

// View class

class CredentialsCookieHandler {

	private $usernameCookieName = 'username';
	private $passwordCookieName = 'password';

	public function exists() {
		if(!empty($_COOKIE[$this->usernameCookieName]) && !empty($_COOKIE[$this->passwordCookieName]))
			return true;
		else
			return false;
	}

	public function saveUserCredentials($username, $password) {
		setcookie($this->usernameCookieName, $username, time()+56000);
		setcookie($this->passwordCookieName, $password, time()+56000);
	}

	public function getUsername() {
		if(isset($_COOKIE[$usernameCookieName]))
			return $_COOKIE[$this->$usernameCookieName];
	}

	public function getPassword() {
		if(isset($_COOKIE[$passwordCookieName]))
			return $_COOKIE[$this->$passwordCookieName];
	}

	public function getCredentials() {
		return array($_COOKIE[$this->usernameCookieName], $_COOKIE[$this->passwordCookieName]);
	}

	public function removeCookies() {
		//unset($_COOKIE[$this->usernameCookieName]);
		//unset($_COOKIE[$this->passwordCookieName]);

		setcookie($this->usernameCookieName, '', time() - 1);
		setcookie($this->passwordCookieName, '', time() - 1);


	}

	/*public function load() {
		if(isset($_COOKIE[$this->cookieName]))
			$output = $_COOKIE[$this->cookieName];
		else
			$output = '';
		
		setcookie($this->cookieName, '', time() - 1);

		return $output;
	}*/
}