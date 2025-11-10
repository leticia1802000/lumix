<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css" />
      <link rel="icon" href="img/2logo.png" type="image/png">
  <title>Lumix-Login</title>

</head>

<body class="noSelect">
  <section class="loginSec">
    <div class="login-container">
      <?php
      session_start();
      if (isset($_SESSION['msg'])) {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo '</div>';
      } else {
        echo '<div class="alert alert-info" role="alert">';

        echo '</div>';
      }
      ?>

      <h2>Login</h2>
      <form action="efetua-login.php" method="POST">
        <div class="grupo-input">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Digite seu e-mail" autocomplete="off" required>
        </div>

        <div class="grupo-input">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" class="login-btn">Login</button>
      </form>

      <div class="links-extra">
        <p><a href="solicitar-recuperacao.php">Esqueceu sua senha?</a></p>
        <p><a href="form-cadastra-usuario.php">Ainda não sou usuário</a></p>
      </div>

    </div>
  </section>

</body>
</html>