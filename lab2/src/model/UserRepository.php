<?php

namespace model;

require_once('src/model/Database.php');
require_once('src/model/User.php');

class UserRepository {

    /**
     * @var Database
     */
    public $database;

    public function __construct() {
        $this->database = new Database();
        $this->database->assertTable(User::class);
    }

    /**
     * @param User $user
     * @throws \Exception if username is taken
     */
    public function create(User $user) {
        if ($this->getByUsername($user->getUsername())) {
            throw new \Exception('Username is taken');
        }

        $this->database->insert($user);
    }

    /**
     * @param string $username
     * @return User|null An user object or null if not found
     */
    public function getByUsername($username) {
        return $this->database->select(User::class, '`username` = ?', [$username], 1);
    }

    /**
     * @param Token $token
     * @return User|null An user object or null if not found
     */
    public function getByToken(Token $token) {
        return $this->database->get(User::class, $token->getUserId());
    }
}
