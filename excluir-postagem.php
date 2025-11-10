<?php

session_start();
if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['success'=>false,'message'=>'Usuário não logado']);
    exit;
}
require_once "src/PostagemDAO.php";

header('Content-Type: application/json'); // Retorna JSON

$idpostagens = $_POST['idpostagens'] ?? null;
$idusuario = $_SESSION['idusuario'] ?? null;

if (!$idpostagens || !$idusuario) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$excluido = PostagemDAO::excluirPostagem($idpostagens, $idusuario);

if ($excluido) {
    echo json_encode(['success' => true, 'message' => 'Postagem excluída']);
} else {
    echo json_encode(['success' => false, 'message' => 'Não foi possível excluir a postagem']);
}
exit;
