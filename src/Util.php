<?php
class Util
{
    public static function salvarArquivo()
    {
        // Define o diretório onde os arquivos serão salvos
        $diretorioUpload = "uploads/";

        // Verifica se o diretório existe, senão, cria
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0755, true);
        }

        // Verifica se um arquivo foi enviado
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $arquivoTmp = $_FILES['foto']['tmp_name'];
            $nomeOriginal = basename($_FILES['foto']['name']);
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            // Gera um nome único para o arquivo
            $nomeUnico = uniqid("img_", true) . "." . $extensao;

            // Caminho final
            $caminhoFinal = $diretorioUpload . $nomeUnico;

            // Move o arquivo
            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                return $nomeUnico;
            }
        }
        return false;
    }

    public static function salvarImagem($nomeCampo)
    {
        // Define o diretório onde os arquivos serão salvos
        $diretorioUpload = "uploads/";

        // Verifica se o diretório existe, senão, cria
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0755, true);
        }

        // Verifica se um arquivo foi enviado
        if (isset($_FILES[$nomeCampo]) && $_FILES[$nomeCampo]['error'] === UPLOAD_ERR_OK) {
            $arquivoTmp = $_FILES[$nomeCampo]['tmp_name'];
            $nomeOriginal = basename($_FILES[$nomeCampo]['name']);
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            // Gera um nome único para o arquivo
            $nomeUnico = uniqid("img_", true) . "." . $extensao;

            // Caminho final
            $caminhoFinal = $diretorioUpload . $nomeUnico;

            // Move o arquivo
            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                return $nomeUnico;
            }
        }
        return false;
    }
}
