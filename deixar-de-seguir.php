<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once "src/SeguidoDAO.php";


$idusuario = $_SESSION['idusuario'] ?? null;
$idseguido = $_POST['idseguido'] ?? null;

if (!$idusuario || !$idseguido) {
    echo json_encode(['success' => false, 'error' => 'Dados ausentes']);
    exit;
}

try {
    SeguidoDAO::deixarDeSeguir($idusuario, $idseguido);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
