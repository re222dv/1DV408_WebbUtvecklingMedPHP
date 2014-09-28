<?php

namespace model;

require_once('src/model/User.php');

class LoginModel {
    private static $usernameLocation = 'username';

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    // Check if the supplied credentials are valid
    public function logIn($username, $password) {
        $user = $this->userRepository->getByUsername($username);

        if ($user and $user->verifyPassword($password)) {
            $_SESSION[self::$usernameLocation] = $username;
            return true;
        }

        return false;
    }
    public function logInByToken($token) {
        $user = $this->userRepository->getByToken($token);

        if ($user) {
            $_SESSION[self::$usernameLocation] = $user->getUsername();
            return true;
        }

        return false;
    }

    // Set the loginststatus to logged out
    public function logOut() {
        unset($_SESSION[self::$usernameLocation]);
    }

    public function isLoggedIn() {
        return isset($_SESSION[self::$usernameLocation]);
    }

    /**
     * @return User|null null if not logged in
     */
    public function getUser() {
        return $this->userRepository->getByUsername($_SESSION[self::$usernameLocation]);
    }
}
