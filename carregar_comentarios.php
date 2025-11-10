<?php
require_once "src/ComentarioDAO.php";

$idpostagens = $_GET['idpostagens'] ?? null;

if (!$idpostagens) {
    echo json_encode(['erro' => 'ID da postagem não informado']);
    exit;
}

$comentarios = ComentarioDAO::listarPorPostagem($idpostagens);
echo json_encode($comentarios);
?>
