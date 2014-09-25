<?php

namespace view;

use model\LoginModel;

require_once('src/view/Message.php');

class LoginView {

    /**
     * @var LoginModel
     */
    private $loginModel;
    /**
     * @var UrlView
     */
    private $url;
    private $message;

    // $_POST[] locations
    private static $usernameLocation = 'username';
    private static $passwordLocation = 'password';
    private static $loginLocation = 'login';
    private static $logoutLocation = 'logout';
    private static $rememberMeLocation = 'rememberMe';

    public function __construct(LoginModel $loginModel, UrlView $url) {
        $this->loginModel = $loginModel;
        $this->url = $url;
        $this->message = new Message();
    }

    // Check if user pressed the Login-button
    public function didUserLogin() {
        return isset($_POST[self::$loginLocation]);
    }

    // Check if user pressed the Logout-button
    public function didUserLogout() {
        return isset($_POST[self::$logoutLocation]);
    }

    // Check if user has supplied enough data
    public function hasValidInput() {
        if (!empty($_POST[self::$usernameLocation]) && !empty($_POST[self::$passwordLocation])) {
            return true;
        } elseif (empty($_POST[self::$usernameLocation])) {
            $this->message->saveMessage('Användarnamn saknas');
        } else {
            $this->message->saveMessage('Lösenord saknas');
        }
    }

    public function getUsername() {
        return $_POST[self::$usernameLocation];
    }

    public function getPassword() {
        return $_POST[self::$passwordLocation];
    }

    public function setRememberMeLoginMessage() {
        $this->message->saveMessage('Inloggning lyckades och vi kommer ihåg dig nästa gång');
    }

    public function setLoginMessage() {
        $this->message->saveMessage('Inloggning lyckades');
    }

    public function setFailMessage() {
        $this->message->saveMessage('Felaktigt användarnamn och/eller lösenord');
    }

    public function setLogoutMessage() {
        $this->message->saveMessage('Du har nu loggat ut');
    }

    public function setCookieLoginMessage() {
        $this->message->saveMessage('Inloggning lyckades via cookies');
    }

    public function setFaultyCookieMessage() {
        $this->message->saveMessage('Felaktig information i cookie');
    }

    // Check if user wants to be remembered
    public function doRememberMe() {
        return isset($_POST[self::$rememberMeLocation]);
    }

    public function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    // Login HTML
    public function getLoginHTML() {
        $output = '
			<a href="'.$this->url->getRegisterUrl().'">Registrera ny användare</a>
			<h2>Ej inloggad</h2>
			<form action="'.$_SERVER['PHP_SELF'].' " method="post">
				<fieldset>
					<legend>Login</legend>';

        if ($this->message->hasMessage()) {
            $output .= '<p>'.$this->message->getMessage().'</p>';
        }

        $output .= '
					<label>Användarnamn
						<input type="text" name="'.self::$usernameLocation.'"';

        if (isset($_POST[self::$usernameLocation]))
            $output .= ' value="'.$_POST[self::$usernameLocation].'"';

        $output .= '/>
					</label>

					<label>Lösenord
						<input type="password" name="'.self::$passwordLocation.'"/>
					</label>

					<label>
						<input type="checkbox" name="'.self::$rememberMeLocation.'"/>
						Håll mig inloggad
					</label>

					<input type="submit" name="'.self::$loginLocation.'" value="Logga in"/>
				</fieldset>
			</form>';

        return $output;
    }

    // Logout HTML
    public function getLogoutHTML() {
        $output = '<h2>'.$this->loginModel->getUser()->getUsername().' är inloggad</h2>';

        $output .= '
			<form action="'.$_SERVER['PHP_SELF'].' " method="post">';

        if ($this->message->hasMessage()) {
            $output .= '<p>'.$this->message->getMessage().'</p>';
        }

        $output .= '
				<input type="submit" name="'.self::$logoutLocation.'" value="Logga ut"/>
			</form>';

        return $output;
    }
}
