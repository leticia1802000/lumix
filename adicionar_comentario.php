<?php
session_start();
require_once "src/ComentarioDAO.php";

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['erro' => 'Usuário não logado']);
    exit;
}

$idusuario = $_SESSION['idusuario'];
$idpostagens = $_POST['idpostagens'] ?? null;
$texto = trim($_POST['texto'] ?? '');

if (!$idpostagens || $texto === '') {
    echo json_encode(['erro' => 'Dados inválidos']);
    exit;
}

ComentarioDAO::adicionar($idpostagens, $idusuario, $texto);

$comentarios = ComentarioDAO::listarPorPostagem($idpostagens);
echo json_encode($comentarios);
?>
