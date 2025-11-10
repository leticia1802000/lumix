<?php
require "src/ConexaoBD.php";
$pdo = ConexaoBD::conectar();

$email = $_POST['email'] ?? '';

$sql = $pdo->prepare("SELECT idusuario FROM usuarios WHERE email = ?");
$sql->execute([$email]);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Recuperação de Senha</title>
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
      color: #fff;
    }
   
    .container {
       background: rgba(255, 255, 255, 0.05);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
          backdrop-filter: blur(8px);
      width: 100%;
      max-width: 400px;
      text-align: center;

    }

    .login-btn {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 999px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  background: linear-gradient(90deg, #634996, #4f46e5);
  color: white;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.login-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
}


    h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    .link-box {
      background-color: rgba(0, 0, 0, 0.3);
      padding: 15px;
      border-radius: 8px;
      word-break: break-all;
      margin-top: 10px;
      font-size: 14px;
    }

    a {
      color: #fff;
      text-decoration: underline;
    }

    .error {
      color: #ff6b6b;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    if ($sql->rowCount() > 0) {
        $token = bin2hex(random_bytes(16));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $pdo->prepare("UPDATE usuarios SET token_recuperacao=?, token_expira=? WHERE email=?")
            ->execute([$token, $expira, $email]);

        $link = "http://localhost:3000/redefinir-senha.php?token=$token";
        echo "<h2>Seu link de recuperação</h2>";
        echo "<div class='link-box'><a href='$link'>$link</a></div>";
    } else {
        echo "<h2 class='error'>E-mail não encontrado!</h2>";
    }
    ?>
  </div>
</body>
</html>
