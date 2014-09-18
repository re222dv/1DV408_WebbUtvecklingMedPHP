<?php

namespace view;

require_once('src/model/CookieScrambler.php');

class CredentialsHandler {

	private $usernameCookieName = 'username';
	private $passwordCookieName = 'password';
	private $cookieScrambler;	

	public function __construct() {
		$this->cookieScrambler = new \model\CookieScrambler();
	}

	public function cookieExist() {
		return !empty($_COOKIE[$this->usernameCookieName]) && !empty($_COOKIE[$this->passwordCookieName]);
	}

	public function saveCredentials(array $userCredentials) {

		$filename = $userCredentials[0] . '.txt';

		$endTime = time() + 15;
		file_put_contents($filename, $endTime);

		setcookie($this->usernameCookieName, $userCredentials[0], $endTime);
		setcookie($this->passwordCookieName, $this->cookieScrambler->encryptCookie($userCredentials[1]), $endTime);
	}

	public function isValidCookie() {
		
		$filename = $this->getUsername() . '.txt';
			
		if(@file_get_contents($filename) == false)
			return false;
		else 
			return time() < file_get_contents($filename);
	}

	public function getUsername() {
		return $_COOKIE[$this->usernameCookieName];
	}

	public function getCredentials() {
		return array($_COOKIE[$this->usernameCookieName], $this->cookieScrambler->decryptCookie($_COOKIE[$this->passwordCookieName]));
	}

	public function clearCredentials() {
		setcookie($this->usernameCookieName, '', time() - 1);
		setcookie($this->passwordCookieName, '', time() - 1);
	}
}