<?php

namespace model;

class User {
    const TOO_SHORT = 1;
    const TOO_LONG = 2;
    const INVALID_CHARS = 3;

    const INVALID_USERNAME_CHARS = '/[^a-z0-9\-_\.]/i';

    public function setUsername($username) {
        $length = mb_strlen($username);
        if ($length < 3) {
            throw new \Exception(3, self::TOO_SHORT);
        } elseif ($length > 20) {
            throw new \Exception(20, self::TOO_LONG);
        }
        if (preg_match(self::INVALID_USERNAME_CHARS, $username)) {
            throw new \Exception(null, self::INVALID_CHARS);
        }
    }

    public function setPassword($password) {
        $length = mb_strlen($password);
        if ($length < 6) {
            throw new \Exception(6, self::TOO_SHORT);
        }
    }
}
