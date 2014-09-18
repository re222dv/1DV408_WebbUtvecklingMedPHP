<?php

namespace model;

class UserControl {

	private $sessionLocation = 'userAgent';

	public function checkUserAgent($userAgentString) {
		if(!isset($_SESSION[$this->sessionLocation])) {
			$_SESSION[$this->sessionLocation] = $userAgentString;
			return true;
		}

		return $_SESSION[$this->sessionLocation] == $userAgentString;
	}
}