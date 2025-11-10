<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <div class="loginSec">
        <div class="login-container">
            <h2>Recuperar Senha</h2>
            <form action="processar-recuperacao.php" method="post">
                <div class="grupo-input">

                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
                    
                </div>
                <input class="login-btn" type="submit" value="Enviar link de recuperação">
            </form>
            <div class="links-extra">
                <a href="login.php">Voltar ao login</a>
            </div>
        </div>
    </div>
</body>

</html>