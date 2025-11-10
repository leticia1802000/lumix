<?php
session_start();
require "src/UsuarioDAO.php";

try {
    UsuarioDAO::cadastrarUsuario($_POST);
    $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
} catch (PDOException $e) {
    // Código 23000 é erro de violação de UNIQUE
    if ($e->getCode() == 23000) {
        $_SESSION['msg'] = "<div class='alert alert-warning'>Ops! Este email já está cadastrado.</div>";
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro no cadastro. Tente novamente.</div>";
    }
}

// Redireciona para a página de login mostrando a mensagem
header("Location: login.php");
exit;
?>
