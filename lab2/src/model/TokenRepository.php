<?php

namespace model;

require_once('src/model/Database.php');
require_once('src/model/Token.php');

class TokenRepository {

    /**
     * @var Database
     */
    public $database;

    public function __construct() {
        $this->database = new Database();
        $this->database->assertTable(Token::class);
    }

    /**
     * @param Token $token
     */
    public function insert(Token $token) {
        $this->database->insert($token);
    }

    /**
     * @param $secret
     * @return Token
     * @throws \Exception if the token is invalid
     */
    public function getBySecret($secret) {
        $token = $this->database->select(Token::class, '`secret` = ?', [$secret], 1);

        if (!$token or !$token->isValid()) {
            throw new \Exception('Token not valid');
        }

        return $token;
    }
}
