<?php

namespace view;

require_once('src/model/TokenRepository.php');

use model\Token;
use model\TokenRepository;
use model\User;

// Handles the user credentials cookies
class CredentialsHandler {
    // $_COOKIE[] keys
    private static $secretLocation = 'secret';

    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    public function __construct() {
        $this->tokenRepository = new TokenRepository();
    }

    // Check if cookie exists for both username and password
    public function cookieExist() {
        return isset($_COOKIE[self::$secretLocation]);
    }

    // Save username and password in cookies and save timestamp on file
    public function saveCredentials(User $user) {
        $token = new Token($user);

        setcookie(self::$secretLocation, $token->getSecret(), $token->getExpirationDate());
        $this->tokenRepository->insert($token);
    }

    /**
     * @return Token
     * @throws \Exception if the token is invalid
     */
    public function getCredentials() {
        return $this->tokenRepository->getBySecret($_COOKIE[self::$secretLocation]);
    }

    // Remove cookies for username and password
    public function clearCredentials() {
        setcookie(self::$secretLocation, null, 1);
    }
}
