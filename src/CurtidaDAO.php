<?php
require_once "ConexaoBD.php";

class CurtidaDAO
{
    // Curtir um post
   // Curtir um post
public static function curtir($idusuario, $idpostagens)
{
    $conexao = ConexaoBD::conectar();
    $sql = "INSERT INTO curtidas (idcurtida, idusuario) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $idpostagens); // <- aqui passa o ID do post
    $stmt->bindParam(2, $idusuario);
    $stmt->execute();
}

// Verificar se já curtiu
public static function jaCurtiu($idusuario, $idpostagens)
{
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT COUNT(*) FROM curtidas WHERE idusuario = ? AND idcurtida = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $idusuario);
    $stmt->bindParam(2, $idpostagens); // <- aqui passa o ID do post
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Descurtir
public static function descurtir($idusuario, $idpostagens)
{
    $conexao = ConexaoBD::conectar();
    $sql = "DELETE FROM curtidas WHERE idusuario = ? AND idcurtida = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $idusuario);
    $stmt->bindParam(2, $idpostagens);
    $stmt->execute();
}

// Contar curtidas
public static function contarCurtidas($idpostagens)
{
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT COUNT(*) as total FROM curtidas WHERE idcurtida = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $idpostagens);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
