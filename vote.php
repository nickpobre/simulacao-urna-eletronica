<?php
$type = $_POST['type'] ?? null;
$candidateNumber = $_POST['candidate'] ?? null;

require_once 'classes/VotingContext.php';
require_once 'classes/NominalVote.php';
require_once 'classes/BlankVote.php';
require_once 'classes/NullVote.php';

$context = new VotingContext();

switch ($type) {
    case 'nominal':
        $context->setStrategy(new NominalVote());
        break;
    case 'blank':
        $context->setStrategy(new BlankVote());
        break;
    case 'null':
        $context->setStrategy(new NullVote());
        break;
    default:
        die("Tipo de voto inválido.");
}

$context->executeStrategy(['candidate' => $candidateNumber]);
header('Location: index.php');