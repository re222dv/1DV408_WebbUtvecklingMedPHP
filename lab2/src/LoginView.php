<?php

require_once('CookieStorage.php');

class LoginView {

	private $loginModel;
	private $messages;

	public function __construct($loginModel) {
		$this->loginModel = $loginModel;
		$this->messages = new CookieStorage();
	}

	public function didUserLogin() {
		if(isset($_POST['login']))
			return true;
		else
			return false;
	}

	public function didUserLogout() {
		if(isset($_POST['logout']))
			return true;
		else
			return false;
	}

	public function isValidInput() {
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			return true;
		} elseif(empty($_POST['username'])) {
			$this->messages->save('Användarnamn saknas');
		} else {
			$this->messages->save('Lösenord saknas');
		}
	}

	public function setLoginMessage() {
		$this->messages->save('Inloggning lyckades');
	}

	public function setFailMessage() {
		$this->messages->save('Felaktigt användarnamn och/eller lösenord');
	}

	public function setLogoutMessage() {
		$this->messages->save('Du har nu loggat ut');
	}

	public function getCredentials() {
		return array('username' => $_POST['username'], 'password' => $_POST['password']);
	}

	public function getHTMLLogin() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')	
			header('Location: ' . $_SERVER['PHP_SELF']);

		$output = '
			<h2>Ej inloggad</h2>
			<form action="' . $_SERVER["PHP_SELF"] .' " method="post">
				<fieldset>
					<legend>Login</legend>';

		if($this->messages->exists())
			$output .= '<p>' . $this->messages->load() . '</p>';				

		$output .= '
					<label>Användarnamn
						<input type="text" name="username"';

		// TODO Fix value after header location
		if(isset($_POST['username']))
			$output .= 'value' . $_POST['username'];

		$output .= '/>
					</label>
					
					<label>Lösenord
						<input type="text" name="password"/>
					</label>

					<label>
						<input type="checkbox" name="rememberMe"/>
						Remember me
					</label>
			
					<input type="submit" name="login" value="Logga in"/>
				</fieldset>
			</form>';
		
		return $output;
	
		/*if($this->didUserLogin()) {
			header('Location: ' . $_SERVER['PHP_SELF']);
			$this->messages->save('Inloggad!');
		} else {
			$output .= $this->messages->load();
		}*/
	}

	public function getHTMLLogout() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')	
			header('Location: ' . $_SERVER['PHP_SELF']);

		$output = '<h2>' . $this->loginModel->getUsername() . ' är inloggad</h2>';

		$output .= '
			<form action="' . $_SERVER["PHP_SELF"] .' " method="post">';
				
		if($this->messages->exists())
			$output .= '<p>' . $this->messages->load() . '</p>';	

		$output .= '
				<input type="submit" name="logout" value="Logga ut"/>
			</form>';

		return $output;
	}
}