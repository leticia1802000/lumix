<?php
session_start();
require_once "src/SeguidoDAO.php";

header('Content-Type: application/json');

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['error' => 'Sessão não iniciada']);
    exit;
}

$idusuario = $_SESSION['idusuario'];
$seguido = SeguidoDAO::contarSeguidos($idusuario);

echo json_encode(['total' => $seguido['seguidos']]);
