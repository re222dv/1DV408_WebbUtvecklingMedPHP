<?php

// MODEL

class CookieScrambler {
	
	public function encryptCookie($cookie) {
		return mcrypt_encrypt(MCRYPT_BLOWFISH, "DettaVarInteLätt", $cookie, MCRYPT_MODE_ECB);
	}

	public function decryptCookie($cookie) {
		return mcrypt_decrypt(MCRYPT_BLOWFISH, "DettaVarInteLätt", $cookie, MCRYPT_MODE_ECB);
	}
}