<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class MusicaDAO
{
public static function cadastrarMusica($dados)
{
    $conexao = ConexaoBD::conectar();

    $sql = "INSERT INTO musicas (idusuario, nomemusica, cantormusica, fotomusica) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(1, $dados['idusuario']); // novo campo
    $stmt->bindParam(2, $dados['nomemusica']);
    $stmt->bindParam(3, $dados['cantormusica']);
    $fotoMusica = Util::salvarImagem('fotomusica');
    $stmt->bindParam(4, $fotoMusica);

    $stmt->execute();
}


public static function listarMusicas($idusuario, $limite = 6)
{
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT nomemusica, cantormusica, fotomusica 
            FROM musicas 
            WHERE idusuario = :idusuario
            ORDER BY idmusica DESC 
            LIMIT :limite";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':idusuario', (int)$idusuario, PDO::PARAM_INT);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}

