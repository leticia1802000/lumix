<?php
require_once "ConexaoBD.php";

class ComentarioDAO {

    // Listar comentários de uma postagem
    public static function listarPorPostagem($idpostagens) {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT c.*, u.apelido, u.foto AS foto_usuario
                FROM comentarios c
                JOIN usuarios u ON c.idusuario = u.idusuario
                WHERE c.idpostagens = :idpostagens
                ORDER BY c.criado_em ASC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':idpostagens' => $idpostagens]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Adicionar novo comentário
    public static function adicionar($idpostagens, $idusuario, $texto) {
        $conexao = ConexaoBD::conectar();
        $sql = "INSERT INTO comentarios (idpostagens, idusuario, texto, criado_em)
                VALUES (:idpostagens, :idusuario, :texto, NOW())";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':idpostagens' => $idpostagens,
            ':idusuario' => $idusuario,
            ':texto' => $texto
        ]);
        return $conexao->lastInsertId();
    }
}
?>
