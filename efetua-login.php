<?php
session_start();
require "src/UsuarioDAO.php";

if ($usuario = UsuarioDAO::validarUsuario($_POST)) {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['idusuario'] = $usuario['idusuario'];
    $_SESSION['apelido'] = $usuario['apelido'];
    $_SESSION['foto'] = $usuario['foto'];
    $_SESSION['fotocapa'] = $usuario['fotocapa'];
    $_SESSION['cantorFav'] = $usuario['cantorFav'];
       $_SESSION['genero'] = $usuario['genero'];

    $_SESSION['ocupacao'] = $usuario['ocupacao'];
    header("Location:site.php");
} else {
    $_SESSION['msg'] = "Usuário ou senha inválido.";
    header("Location:login.php");
}
