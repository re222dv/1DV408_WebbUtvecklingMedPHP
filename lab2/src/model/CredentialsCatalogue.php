<?php

namespace model;

class CredentialsCatalogue {

	private $catalogue = array();

	public function __construct() {
		$this->addUser('Admin', 'Password');		
		$this->addUser('Nisse', 'Tisse');
	}

	public function getCatalogue() {
		return $this->catalogue;
	}

	public function addUser($username, $password) {
		$this->catalogue[$username] = $password; 
	}
}