<?php
session_start();
require_once "src/MusicaDAO.php";
require_once "src/Util.php";

try {
    $dados = [
            'idusuario' => $_POST['idusuario'],

        'nomemusica' => $_POST['nomemusica'],
        'cantormusica' => $_POST['cantormusica']
    ];

    MusicaDAO::cadastrarMusica($dados);

    $_SESSION['msg'] = "<div class='alert alert-success'>Música cadastrada com sucesso!</div>";
} catch (PDOException $e) {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao cadastrar música. Tente novamente.</div>";
}

header("Location: perfil.php");
exit;
