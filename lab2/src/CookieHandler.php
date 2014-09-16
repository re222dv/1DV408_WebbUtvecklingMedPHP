<?php

// View class

class CookieHandler {

	private $cookieLocation;

	public function __construct($cookieLocation) {
		 $this->cookieLocation = $cookieLocation;
	}

	public function exists() {
		if(!empty($_COOKIE[$this->cookieLocation]))
			return true;
		else
			return false;
	}

	public function save($input) {
		setcookie($this->cookieLocation, $input, -1);
	}

	public function load() {
		if(isset($_COOKIE[$this->cookieLocation]))
			$output = $_COOKIE[$this->cookieLocation];
		else
			$output = '';
		
		setcookie($this->cookieLocation, '', time() - 1);

		return $output;
	}
}