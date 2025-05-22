<?php
require_once 'VoteStrategy.php';
require_once 'db.php';

class NullVote implements VoteStrategy {
    public function vote($data) {
        global $pdo;
        $pdo->exec("INSERT INTO votos (tipo) VALUES ('null')");
    }
}