<?php
require "ConexaoBD.php";
require_once 'src/Util.php';


class UsuarioDAO
{

    public static function cadastrarUsuario($dados)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "insert into usuarios (apelido, email, senha, foto, cantorFav, ocupacao, genero, fotocapa) values (?,?,?,?,?,?,?,?)";
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(1, $dados['apelido']);
        $stmt->bindParam(2, $dados['email']);
        $senhaCriptografada = md5($dados['senha']);
        $stmt->bindParam(3, $senhaCriptografada);
        $foto = Util::salvarImagem('foto');
        $stmt->bindParam(4, $foto);
        $stmt->bindParam(5, $dados['cantorFav']);
        $stmt->bindParam(6, $dados['ocupacao']);
        $stmt->bindParam(7, $dados['genero']);
        $fotocapa = Util::salvarImagem('fotocapa');
        $stmt->bindParam(8, $fotocapa);




        $stmt->execute();
    }

    public static function validarUsuario($dados)
    {
        $senhaCriptografada = md5($dados['senha']);
        $sql = "select * from usuarios where email=? AND senha=?";

        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $dados['email']);
        $stmt->bindParam(2, $senhaCriptografada);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $usuario;
        } else {
            return false;
        }
    }

    public static function listarUsuarios($idusuario)
    {

        $sql = "select * from usuarios where idusuario!=?";

        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idusuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarUsuarioId($idusuario)
    {

        $sql = "select * from usuarios where idusuario=?";

        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idusuario);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarUsuarios($idusuario, $apelido)
    {

        $sql = "select * from usuarios where idusuario!=? and apelido like ?";

        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idusuario);
        $apelido = '%' . $apelido . '%';
        $stmt->bindParam(2, $apelido);

        $stmt->execute();

        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    

    public static function buscarUsuariosParaSeguir($idusuario, $apelido)
    {

        $sql = "SELECT u.* FROM usuarios u 
            WHERE u.idusuario != ? AND u.apelido like ?
            AND u.idusuario NOT IN (SELECT s.idseguidos FROM seguidos s  WHERE s.idusuario = ?);";


        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idusuario);
        $apelido = '%' . $apelido . '%';
        $stmt->bindParam(2, $apelido);
        $stmt->bindParam(3, $idusuario);

        $stmt->execute();

        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function listarUsuariosAleatorios($limite = 3)
{
    $conexao = ConexaoBD::conectar();

    $sql = "SELECT apelido, email, foto, idusuario 
            FROM usuarios 
            ORDER BY RAND()";

    if ($limite !== null) {
        $sql .= " LIMIT " . (int)$limite;
    }

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
