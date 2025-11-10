<?php
require_once "ConexaoBD.php";
require_once "Util.php";
class PostagemDAO {    

    // Cadastrar nova postagem
   public static function cadastrar($dados, $idusuario) {
    $texto = $dados['texto'];
    $foto = Util::salvarArquivo();
    $publico = $dados['publico'];
    $criado_em = date('Y-m-d H:i:s');

    // Captura o valor de 'sentimento' passado pela URL ou define como 'neutro' por padrão
$sentimento = isset($dados['sentimento']) ? $dados['sentimento'] : 'neutro'; // valor padrão "neutro"

    $conexao = ConexaoBD::conectar();
    $sql = "INSERT INTO postagens (texto, foto, idusuario, publico, criado_em, sentimento) 
            VALUES (?,?,?,?,?,?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $texto);
    $stmt->bindParam(2, $foto);
    $stmt->bindParam(3, $idusuario);
    $stmt->bindParam(4, $publico);
    $stmt->bindParam(5, $criado_em);
    $stmt->bindParam(6, $sentimento);  // Aqui, bind o valor de $sentimento
    $stmt->execute();

    return $conexao->lastInsertId();
}


public static function listarTimeline() {
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT p.*, u.apelido, u.foto AS foto_usuario
            FROM postagens p
            JOIN usuarios u ON p.idusuario = u.idusuario
            ORDER BY p.criado_em DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public static function listarPorUsuario($idusuario) {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM postagens WHERE idusuario = :idusuario ORDER BY criado_em DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':idusuario' => $idusuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // // Buscar todas postagens públicas
    // public static function listarPublicas() {
    //     $conexao = ConexaoBD::conectar();
    //     $sql = "SELECT p.*, u.apelido, u.foto as foto_usuario 
    //             FROM postagens p 
    //             JOIN usuarios u ON p.idusuario = u.idusuario
    //             WHERE p.publico = 1 
    //             ORDER BY p.criado_em DESC";
    //     $stmt = $conexao->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

        public static function contarPostagens($idusuario)
        {
   $sql = "SELECT COUNT(*) AS totalposts FROM postagens WHERE idusuario = ?";
               $conexao = ConexaoBD::conectar();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1, $idusuario);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
public static function listarPorSentimento($sentimento) {
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT p.*, u.apelido, u.foto AS foto_usuario
            FROM postagens p
            JOIN usuarios u ON p.idusuario = u.idusuario
            WHERE p.sentimento = :sentimento
            ORDER BY p.criado_em DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([':sentimento' => $sentimento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




public static function excluirPostagem($idpostagens, $idusuario) {
    $conexao = ConexaoBD::conectar();

    // Verifica se o post pertence ao usuário antes de excluir
    $sql = "DELETE FROM postagens WHERE idpostagens = :idpostagens AND idusuario = :idusuario";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([':idpostagens' => $idpostagens, ':idusuario' => $idusuario]);

    return $stmt->rowCount() > 0;  // Retorna true se o post foi excluído
}


}
?>