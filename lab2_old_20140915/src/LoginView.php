<?php

require_once('CookieStorage.php');

// TEMP
require_once('UserCookies.php');

class LoginView {

	private $loginModel;
	private $messages;
	// TEMP
	private $userCookies;

	public function __construct($loginModel) {
		$this->loginModel = $loginModel;
		$this->messages = new CookieStorage();

		// TEMP
		$this->userCookies = new UserCookies();
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

	public function setRemberMeLoginMessage() {
		$this->messages->save('Inloggning lyckades och vi kommer ihåg dig nästa gång');
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
		//return array('username' => $_POST['username'], 'password' => $_POST['password']);
		return array($_POST['username'], $_POST['password']);
	}

	// TEMP USERCOOKIES START

	public function cookiesExist() {
		return $this->userCookies->exists();
	}

	public function readUserCookies() {

		// Returns array
			//var_dump($this->userCookies->getCredentials());
			//die();
		return $this->userCookies->getCredentials();
	}
	
	public function setCookieLoginMessage() {
		$this->messages->save('Inloggning lyckades via cookies');
	}

	public function doRememberMe() {
		if(isset($_POST['rememberMe']))
			return true;
		else
			return false;

	}

		public function reloadPage() {
			header('Location: ' . $_SERVER['PHP_SELF']);
		}


	public function removeUserCookies() {
		$this->userCookies->removeCookies();
	}

	public function saveCredentials() {

		$this->userCookies->saveUserCredentials($_POST['username'], $_POST['password']);
	}

	// TEMP USERCOOKIES END


	//////////
	/*public function saveUserInput() {
		
		if(isset($_POST['username']))
			setcookie('userInput', $_POST['username'], -1);
	}

	public function getUserInput() {
		
		if(isset($_COOKIE['userInput'])) {
			$userInput = $_COOKIE['userInput'];
			//setcookie($_COOKIE['userInput'], '', time() - 1);
			//unset($_COOKIE['userInput']);
			return $userInput;
		}
	}*/
	////////

	public function getHTMLLogin() {
		
		////
		//$this->saveUserInput();

		////


		if($_SERVER['REQUEST_METHOD'] == 'POST')	
			$this->reloadPage();
			//header('Location: ' . $_SERVER['PHP_SELF']);





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

		/*
			check for cookie

			if cookie exists read



		*/
			/////////////////////  Få bort kakan!!!!!!!!!!!!!!!
		if(isset($_POST['username']))
			setcookie('userInput', $_POST['username'], -1);


		if(isset($_COOKIE['userInput'])) {
			$output .= ' value="' . $_COOKIE['userInput'] . '"';
			setcookie($_COOKIE['userInput'], '', time() - 1);
		}
		
		


		// if(isset($_POST['username'])) {
		// 	$output .= ' value=' . $_POST['username'];
		// }



		//////////////////////////////////////////////
		$output .= '/>
					</label>
					
					<label>Lösenord
						<input type="text" name="password"/>
					</label>

					<label>
						<input type="checkbox" name="rememberMe"/>
						Håll mig inloggad
					</label>
			
					<input type="submit" name="login" value="Logga in"/>
				</fieldset>
			</form>';
		
		return $output;
	}

	public function getHTMLLogout() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')	
			$this->reloadPage();

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