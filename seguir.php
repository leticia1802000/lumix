

<?php
include("incs/valida-sessao.php");
require_once "src/SeguidoDAO.php";

$idusuario = $_SESSION['idusuario'];
$idseguido = $_POST['idseguido'] ?? null;

header('Content-Type: application/json');

if (!$idseguido) {
    echo json_encode(['success' => false, 'msg' => 'ID do usuário não enviado']);
    exit;
}

if (SeguidoDAO::verificarSeSegue($idusuario, $idseguido)) {
    echo json_encode(['success' => false, 'msg' => 'Você já segue esse usuário!']);
} else {
    SeguidoDAO::seguir($idusuario, $idseguido);
    echo json_encode(['success' => true]);
}



