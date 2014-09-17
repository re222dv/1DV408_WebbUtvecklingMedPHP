<?php

// View class

require_once('src/CookieScrambler.php');

class CredentialsCookieHandler {

	private static $filename = 'cookieTimes.txt';
	private $usernameCookieName = 'username';
	private $passwordCookieName = 'password';
	private $cookieScrambler;	

	public function __construct() {
		$this->cookieScrambler = new CookieScrambler();
	}


	public function exists() {
		if(!empty($_COOKIE[$this->usernameCookieName]) && !empty($_COOKIE[$this->passwordCookieName]))
			return true;
		else
			return false;
	}

	public function saveUserCredentials($userCredentials) {
		
		$endTime = time() + 15;
		file_put_contents(self::$filename, $endTime);

		setcookie($this->usernameCookieName, $userCredentials[0], $endTime);
		setcookie($this->passwordCookieName, $this->cookieScrambler->encryptCookie($userCredentials[1]), $endTime);
	}

	public function isValidCookies() {
		
		$cookieEndTime = file_get_contents(self::$filename);
		
		if(time() < $cookieEndTime)
			return true;
		else
			return false; 
	}

	public function getUsername() {
		if(isset($_COOKIE[$usernameCookieName]))
			return $_COOKIE[$this->$usernameCookieName];
	}

	public function getPassword() {
		if(isset($_COOKIE[$passwordCookieName]))
			return $this->cookieScrambler->decryptCookie($this->passwordCookieName);
	}

	public function getCredentials() {
		return array($_COOKIE[$this->usernameCookieName], $this->cookieScrambler->decryptCookie($_COOKIE[$this->passwordCookieName]));
	}

	public function removeCookies() {
		setcookie($this->usernameCookieName, '', time() - 1);
		setcookie($this->passwordCookieName, '', time() - 1);
	}
}