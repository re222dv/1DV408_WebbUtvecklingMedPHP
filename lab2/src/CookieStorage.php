<?php

// View class

class CookieStorage {

	private $cookieName = 'CookieStorage';

	public function exists() {
		if(!empty($_COOKIE[$this->cookieName]))
			return true;
		else
			return false;
	}

	public function save($message) {
		setcookie($this->cookieName, $message, -1);
	}

	public function load() {
		if(isset($_COOKIE[$this->cookieName]))
			$output = $_COOKIE[$this->cookieName];
		else
			$output = '';
		
		setcookie($this->cookieName, '', time() - 1);

		return $output;
	}
}