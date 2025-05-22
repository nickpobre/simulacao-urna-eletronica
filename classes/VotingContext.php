<?php
class VotingContext {
    private $strategy;

    public function setStrategy(VoteStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function executeStrategy($data) {
        $this->strategy->vote($data);
    }
}