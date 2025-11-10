<?php
require_once "ConexaoBD.php";
require_once 'src/Util.php';


class CantorDAO
{
 public static function buscarCantor($idcantor, $nome)
    {

        $sql = "select * from cantores where idcantor!=? and nome like ?";

        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idcantor);
        $nome = '%' . $nome . '%';
        $stmt->bindParam(2, $nome);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }






}