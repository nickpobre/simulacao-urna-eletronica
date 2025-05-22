<?php
require_once 'db.php';

if (!isset($_GET['numero'])) {
    echo json_encode(['error' => 'Número não informado']);
    exit;
}

$numero = $_GET['numero'];

$stmt = $pdo->prepare("SELECT nome, partido FROM candidatos WHERE numero = ?");
$stmt->execute([$numero]);
$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

if ($candidato) {
    echo json_encode($candidato);
} else {
    echo json_encode(['error' => 'Candidato não encontrado']);
}