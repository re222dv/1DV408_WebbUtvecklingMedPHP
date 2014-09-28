<?php

namespace model;

class User {
    const TOO_SHORT = 1;
    const TOO_LONG = 2;
    const INVALID_CHARS = 3;

    const INVALID_USERNAME_CHARS = '/[^a-z0-9\-_\.]/i';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * [column varchar(20)]
     */
    private $username;

    /**
     * @var string
     * [column varchar(256)]
     */
    private $hash;

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username [3, 20] [a-z0-9-_.]
     * @throws \Exception If at least one of the rules are not met
     */
    public function setUsername($username) {
        $length = mb_strlen($username);
        if ($length < 3) {
            throw new \Exception(3, self::TOO_SHORT);
        } elseif ($length > 20) {
            throw new \Exception(20, self::TOO_LONG);
        }
        $username = preg_replace(self::INVALID_USERNAME_CHARS, '', $username, -1, $hasInvalid);
        if ($hasInvalid) {
            throw new \Exception($username, self::INVALID_CHARS);
        }

        $this->username = $username;
    }

    /**
     * @param string $password Min length: 6
     * @throws \Exception If the rule are not met
     */
    public function setPassword($password) {
        $length = mb_strlen($password);
        if ($length < 6) {
            throw new \Exception(6, self::TOO_SHORT);
        }

        $this->hash = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isValid() {
        return !empty($this->username) && !empty($this->hash);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password) {
        return password_verify($password, $this->hash);
    }
}
