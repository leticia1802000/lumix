<?php
require_once 'src/ConexaoBD.php';
$pdo = ConexaoBD::conectar();

$token = $_POST['token'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';

if (!$token || !$nova_senha) {
    die("<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
      <meta charset='UTF-8'>
      <title>Erro</title>
      <style>
        body {
          background: linear-gradient(to bottom right, #6a11cb, #2575fc);
          color: #fff;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
          background: rgba(255, 255, 255, 0.05);
          border: 1px solid rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(8px);
          padding: 30px 40px;
          border-radius: 12px;
          text-align: center;
          max-width: 400px;
        }
        h2 {
          color: #ff6b6b;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Dados inválidos!</h2>
      </div>
    </body>
    </html>");
}

$sql = $pdo->prepare("SELECT idusuario FROM usuarios WHERE token_recuperacao=? AND token_expira > NOW()");
$sql->execute([$token]);

if ($sql->rowCount() == 0) {
    die("<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
      <meta charset='UTF-8'>
      <title>Token Inválido</title>
      <style>
        body {
          background: linear-gradient(to bottom right, #6a11cb, #2575fc);
          color: #fff;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
          background: rgba(255, 255, 255, 0.05);
          border: 1px solid rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(8px);
          padding: 30px 40px;
          border-radius: 12px;
          text-align: center;
          max-width: 400px;
        }
        h2 {
          color: #ff6b6b;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Token inválido ou expirado!</h2>
      </div>
    </body>
    </html>");
}

$usuario = $sql->fetch(PDO::FETCH_ASSOC);
$hash = md5($nova_senha); // ou password_hash($nova_senha, PASSWORD_DEFAULT)

$pdo->prepare("UPDATE usuarios SET senha=?, token_recuperacao=NULL, token_expira=NULL WHERE idusuario=?")
    ->execute([$hash, $usuario['idusuario']]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Senha Redefinida</title>
  <style>
    
:root {
  --bg1: #2043b4;
  --bg2: #634996;
  --bg3: #09074e;
  --accent-from: #634996;
  --accent-to: #4f46e5;
  --glass: rgba(255, 255, 255, 0.06);
  --glass-strong: rgba(255, 255, 255, 0.08);
  --text: #ffffff;
  --muted: rgba(255, 255, 255, 0.75);
  --radius: 14px;
  --accent: #a855f7;
  --muted: #6b7280;
  --card-bg: #ffffff;
  --border: #e5e7eb;
}


    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      height: 100vh;
       background: linear-gradient(to bottom right, var(--bg1), var(--bg2), var(--bg3));
  color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      color: var(--text);
    }

    .container {
      background: rgba(255, 255, 255, 0.05);
  border-radius: 20px;
  padding: 3rem 2rem;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
  text-align: center;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.1);
    }

    h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    a {
      color: #fff;
      text-decoration: underline;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Senha redefinida com sucesso!</h2>
    <p>Você já pode fazer <a href="login.php">login</a>.</p>
  </div>
</body>
</html>
