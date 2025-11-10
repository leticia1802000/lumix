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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <title>Cadastro de Música — Lumix</title>
</head>

<body class="noSelect">
  <div class="signup-wrapper">
    <div class="signup-box">
      <div class="mb-4">
        <h1>Cadastre uma música</h1>
        <p>Adicione uma nova música à plataforma com nome, cantor e imagem de capa.</p>
      </div>

      <?php if (isset($_SESSION['msg'])): ?>
        <div class="mb-3"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
      <?php endif; ?>

      <form action="cadastra-musica.php" method="POST" enctype="multipart/form-data" novalidate>

        <!-- Nome da música -->
        <div class="grupo-input mb-3">
          <label for="nomemusica">Nome da música</label>
          <input id="nomemusica" name="nomemusica" type="text" placeholder="Ex: Believer" class="form-control" autocomplete="off" required />
        </div>

        <!-- Cantor -->
        <div class="grupo-input mb-3">
         <input list="cantores" id="cantormusica" name="cantormusica" class="form-control" placeholder="Digite o cantor..." required>
 <div id="listaCantores" class="lista-dropdown"></div>
<datalist id="cantores">
  <?php foreach ($cantores as $c): ?>
    <option value="<?= htmlspecialchars($c['nome']) ?>"></option>
  <?php endforeach; ?>
</datalist>
        </div>

        <!-- Foto da música -->
        <div class="grupo-input mb-4">
          <label for="fotomusica">Foto da música</label>
          <input class="form-control" id="fotomusica" name="fotomusica" type="file" accept="image/*" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Cadastrar Música</button>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
