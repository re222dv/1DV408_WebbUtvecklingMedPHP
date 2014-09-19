<?php

namespace model;

// Contains the valid credentials in an array
class CredentialsCatalogue {

	// Associated array containing valid usernames and passwords
	private $catalogue = array();

	public function __construct() {
		$this->addUser('Admin', 'Password');		
		$this->addUser('Nisse', 'Tisse');
	}

	// Return a reference to the array
	public function getCatalogue() {
		return $this->catalogue;
	}

	// Add a user to the array
	public function addUser($username, $password) {
		$this->catalogue[$username] = $password; 
	}
}