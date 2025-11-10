<?php
require_once "src/ConexaoBD.php";
$pdo = ConexaoBD::conectar();

$token = $_GET['token'] ?? '';

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE token_recuperacao=? AND token_expira > NOW()");
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="css/style.css" />


<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
</head>

<body>
    <div class="loginSec">
        <div class="login-container">
            <h2>Redefinir Senha</h2>
            <form action="atualizar-senha.php" method="post">
                <div class="grupo-input">

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" name="nova_senha" id="nova_senha" required>
                </div>
                <input type="submit" class="login-btn" value="Atualizar Senha">
            </form>
        </div>
    </div>

</body>

</html>