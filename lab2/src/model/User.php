<?php

namespace model;

class User {
    const TOO_SHORT = 1;
    const TOO_LONG = 2;
    const INVALID_CHARS = 3;

    const INVALID_USERNAME_CHARS = '/[^a-z0-9\-_\.]/i';

    private $username;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $length = mb_strlen($username);
        if ($length < 3) {
            throw new \Exception(3, self::TOO_SHORT);
        } elseif ($length > 20) {
            throw new \Exception(20, self::TOO_LONG);
        }
        $this->username = preg_replace(self::INVALID_USERNAME_CHARS, '', $username);
        if ($this->username !== $username) {
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
