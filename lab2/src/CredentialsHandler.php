<?php

// View class

require_once('src/CookieScrambler.php');

class CredentialsHandler {

	private static $filename = 'cookieTime.txt';
	private $usernameCookieName = 'username';
	private $passwordCookieName = 'password';
	private $cookieScrambler;	

	public function __construct() {
		$this->cookieScrambler = new CookieScrambler();
	}

	public function cookieExist() {
		return !empty($_COOKIE[$this->usernameCookieName]) && !empty($_COOKIE[$this->passwordCookieName]);
	}

	public function saveCredentials(array $userCredentials) {
		
		$endTime = time() + 15;
		file_put_contents(self::$filename, $endTime);

		setcookie($this->usernameCookieName, $userCredentials[0], $endTime);
		setcookie($this->passwordCookieName, $this->cookieScrambler->encryptCookie($userCredentials[1]), $endTime);
	}

	public function isValidCookies() {
		
		$cookieEndTime = file_get_contents(self::$filename);
		
		return time() < $cookieEndTime;
	}

	/*public function getUsername() {
		if(isset($_COOKIE[$usernameCookieName]))
			return $_COOKIE[$this->$usernameCookieName];
	}*/

	/*public function getPassword() {
		if(isset($_COOKIE[$passwordCookieName]))
			return $this->cookieScrambler->decryptCookie($this->passwordCookieName);
	}*/

	public function getCredentials() {
		return array($_COOKIE[$this->usernameCookieName], $this->cookieScrambler->decryptCookie($_COOKIE[$this->passwordCookieName]));
	}

	public function clearCredentials() {
		setcookie($this->usernameCookieName, '', time() - 1);
		setcookie($this->passwordCookieName, '', time() - 1);
	}
}