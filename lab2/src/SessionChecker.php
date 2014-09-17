<?php

class SessionChecker {

	public function setUserAgent($userAgentString) {
		if(!isset($_SESSION['userAgent']))
			$_SESSION['userAgent'] = $userAgentString;
	}

	public function getValidUserAgent() {
		if(isset($_SESSION['userAgent']))
			return $_SESSION['userAgent'];
	}

	public function checkUserAgent($userAgentString) {
		if($_SESSION['userAgent'] == $userAgentString)
			return true;
		else
			return false;
	}
}