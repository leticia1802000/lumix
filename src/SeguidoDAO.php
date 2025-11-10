 <?php

    require_once "ConexaoBD.php";


    class SeguidoDAO
    {

        public static function seguir($idusuario, $idseguidos)
        {
            $conexao = ConexaoBD::conectar();

            $sql = "insert into seguidos (idusuario, idseguido) values (?,?)";
            $stmt = $conexao->prepare($sql);

            $stmt->bindParam(1, $idusuario);
            $stmt->bindParam(2, $idseguidos);
            $stmt->execute();
        }



   public static function listarSeguidos($idusuario)
{
    $sql = "SELECT u.*
            FROM usuarios u
            INNER JOIN seguidos s ON u.idusuario = s.idseguido
            WHERE s.idusuario = ?
            LIMIT 8";  // ✅ Limite de 4 resultados

    $conexao = ConexaoBD::conectar();
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $idusuario);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    


        public static function contarSeguidores($idusuario)
        {
            $sql = "SELECT count(*) as seguidores FROM seguidos where idseguido=?;";
            $conexao = ConexaoBD::conectar();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1, $idusuario);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function contarSeguidos($idusuario)
        {
            $sql = "SELECT count(*) as seguidos FROM seguidos where idusuario=?;";
            $conexao = ConexaoBD::conectar();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1, $idusuario);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public static function verificarSeSegue($idusuario, $idseguido) {
    $conexao = ConexaoBD::conectar();
    $sql = "SELECT COUNT(*) FROM seguidos WHERE idusuario = :idusuario AND idseguido = :idseguido";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":idusuario", $idusuario); // quem está seguindo
    $stmt->bindValue(":idseguido", $idseguido); // quem será seguido
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}


public static function deixarDeSeguir($idusuario, $idseguido)
{
    $conexao = ConexaoBD::conectar();

    // SQL para remover o seguimento
    $sql = "DELETE FROM seguidos WHERE idusuario = ? AND idseguido = ?";

    // Prepara a consulta
    $stmt = $conexao->prepare($sql);

    // Faz o binding dos parâmetros
    $stmt->bindParam(1, $idusuario);
    $stmt->bindParam(2, $idseguido);

    // Executa a consulta
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


    }
    ?>