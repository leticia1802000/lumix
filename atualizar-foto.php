<?php
session_start();
require_once "src/UsuarioDAO.php";
require_once "src/ConexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $idusuario = $_POST['idusuario'];
    $arquivo = $_FILES['foto'];

    $nomeArquivo = time() . "_" . basename($arquivo['name']);
    $destino = "uploads/" . $nomeArquivo;

    if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
        // Atualiza no banco
        UsuarioDAO::atualizarFoto($idusuario, $nomeArquivo);

        // 🔥 Atualiza a sessão para refletir a nova imagem
        $_SESSION['foto'] = $nomeArquivo;

        // Redireciona para o perfil
        header("Location: perfil.php?idusuario=$idusuario");
        exit;
    } else {
        echo "Erro ao enviar a imagem.";
    }
} else {
    echo "Requisição inválida.";
}
