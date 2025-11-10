<?php
session_start();
require_once "src/CurtidaDAO.php";

$idpost = $_POST['idpost'] ?? null;
$idusuario = $_SESSION['idusuario'];

if($idpost){
    if(!CurtidaDAO::jaCurtiu($idusuario, $idpost)){
        CurtidaDAO::curtir($idusuario, $idpost);
        $status = 'curtido';
    } else {
        CurtidaDAO::descurtir($idusuario, $idpost);
        $status = 'descurtido';
    }

    $totalCurtidas = CurtidaDAO::contarCurtidas($idpost)['total'];

    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'totalCurtidas' => $totalCurtidas
    ]);
}
