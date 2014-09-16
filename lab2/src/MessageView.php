<?php

require_once('MessageCookieHandler');

class MessageView {
	
	private messageCookie;

	public function __construct() {
		$this->messageCookie = new MessageCookieHandler();
	}

	public function getMessage() {
		return $this->messageCookie->save('Inloggning lyckades via cookies');
	}

	public function setRemberMeLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades och vi kommer ihåg dig nästa gång');
	}

	public function setLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades');
	}

	public function setFailMessage() {
		$this->messageCookie->save('Felaktigt användarnamn och/eller lösenord');
	}

	public function setLogoutMessage() {
		$this->messageCookie->save('Du har nu loggat ut');
	}

	public function setCookieLoginMessage() {
		$this->messageCookie->save('Inloggning lyckades via cookies');
	}

}