<?php
require_once 'VoteStrategy.php';
require_once 'db.php';

class NominalVote implements VoteStrategy {
    public function vote($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO votos (tipo, candidato) VALUES ('nominal', ?)");
        $stmt->execute([$data['candidate']]);
    }
}