<?php
session_start();
require_once "src/CantorDAO.php";

// Buscar todos os cantores
$cantores = CantorDAO::buscarCantor(0, '');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <title>Cadastro — Lumix</title>
</head>

<body class="noSelect">
  <div class="signup-wrapper">
    <div class="signup-box">
      <div class="">
        <h1>Crie sua conta</h1>
        <p>Junte-se à Lumix — descubra música, participe de comunidades e compartilhe sua paixão.</p>
      </div>

      <form action="cadastra-usuario.php" method="POST" enctype="multipart/form-data" novalidate>

        <!-- Apelido -->
        <div class="grupo-input">
          <label for="apelido">Apelido</label>
          <input id="apelido" name="apelido" type="text" placeholder="Como quer ser chamado?" class="form-control" autocomplete="off" required />
        </div>


        <div class="row">
          <div class="grupo-input col-6">
            <label for="cantorFav">Escolha seu cantor favorito</label>
            <input list="cantores" id="cantorFav" name="cantorFav" class="form-control" placeholder="Digite o cantor..." required >
            <div id="listaCantores" class="lista-dropdown"></div>
            <datalist id="cantores">
              <?php foreach ($cantores as $c): ?>
                <option value="<?= htmlspecialchars($c['nome']) ?>"></option>
              <?php endforeach; ?>
            </datalist>

          </div>

          <div class="grupo-input col-6">
            <label for="basic-select-sentimento" class="form-label text-white">Gênero</label>
            <select id="basic-select-sentimento" name="genero" class="input-field1" required>
              <option value="Feminino">Feminino</option>
              <option value="Masculino">Masculino</option>
              <option value="Prefiro não dizer">Prefiro não dizer</option>
            </select>
          </div>
        </div>


        <!-- ocupacao -->
        <div class="grupo-input ">
          <label for="ocupacao">Ocupação</label>
          <input id="ocupacao" name="ocupacao" type="text" placeholder="professor" class="form-control" autocomplete="off" required />
        </div>

        <!-- E-mail -->
        <div class="grupo-input ">
          <label for="email">E-mail</label>
          <input id="email" name="email" type="email" placeholder="seu@exemplo.com" class="form-control" autocomplete="off" required />
        </div>

        <!-- Senha -->
        <div class="grupo-input ">
          <label for="senha">Senha</label>
          <div class="pw-row">
            <input type="password" id="senha" placeholder="Senha" name="senha" class="form-control" required />
            <span id="pwToggle" class="material-symbols-outlined" style="cursor:pointer">visibility_off</span>
          </div>
        </div>


        <div class="row">
          <!-- Foto de perfil -->
          <div class="grupo-input col-6">
            <label>Foto de perfil</label>
            <div class="upload">
              <div class="preview" id="imgPreviewPerfil">+</div>
              <input class="file-input" id="imgFilePerfil" name="foto" type="file" accept="image/*" />
            </div>
          </div>

          <div class="grupo-input col-6">
            <label>Foto de capa</label>
            <div class="upload">
              <div class="preview" id="imgPreviewCapa">+</div>
              <input class="file-input " id="imgFileCapa" name="fotocapa" type="file" accept="image/*" />
            </div>
          </div>
        </div>

        <button type="submit" class="login-btn mt-3">Cadastrar</button>
      </form>
    </div>
  </div>



  <script src="script.js"></script>
</body>

</html>