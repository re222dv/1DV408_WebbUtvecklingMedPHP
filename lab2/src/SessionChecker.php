<?php

// Model

class SessionChecker {

	private $sessionLocation = 'userAgent';

	public function saveUserAgent($userAgentString) {
		//if(!isset($_SESSION[$this->sessionLocation]))
			$_SESSION[$this->sessionLocation] = $userAgentString;
	}

	/*public function getValidUserAgent() {
		if(isset($_SESSION[$this->sessionLocation]))
			return $_SESSION[$this->sessionLocation];
	}*/

	public function isUserAgentSet() {
		return isset($_SESSION[$this->sessionLocation]);
	}

	public function isValidUserAgent($userAgentString) {
		return $_SESSION[$this->sessionLocation] == $userAgentString;
		
		/*if($_SESSION[$this->sessionLocation] == $userAgentString)
			return true;
		else
			return false;*/
	}
}