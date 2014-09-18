<?php

// MODEL

class CookieScrambler {
	
	private static $key = 'DettaVarInteLätt';

	public function encryptCookie($cookieValue) {
		return mcrypt_encrypt(MCRYPT_BLOWFISH, self::$key, $cookieValue, MCRYPT_MODE_ECB);
	}

	public function decryptCookie($cookieValue) {
		return mcrypt_decrypt(MCRYPT_BLOWFISH, self::$key, $cookieValue, MCRYPT_MODE_ECB);
	}
}