<?php
include "incs/nav.php";
require_once "src/UsuarioDAO.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Pega o ID do usuário logado
$idusuario = $_SESSION['idusuario'] ?? null;

// 🔹 Pega o apelido pesquisado (ou vazio)
$apelido = $_GET['apelido'] ?? '';

// 🔹 Se não houver usuário logado, redireciona
if (!$idusuario) {
    header("Location: login.php");
    exit;
}

// 🔹 Busca os usuários
$usuarios = UsuarioDAO::buscarUsuarios($idusuario, $apelido);
?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 
  <title>Sugestao</title>

</head>

<div class="container my-5">
    <?php if (isset($_GET['msg'])): ?>
    <div class="alert-custom">
        <?= htmlspecialchars($_GET['msg']) ?>
    </div>
<?php endif; ?>


    <?php if (!empty($apelido)) : ?>
    <h4 class="text-center mb-4">Resultados da busca por “<?= htmlspecialchars($apelido) ?>”</h4>
    <?php endif; ?>

<div class="sugestoes-lista">
    <?php foreach ($usuarios as $usuario) : ?>
        <div class="usuario-item">
            <div class="usuario-info">
                <a href="perfil.php?idusuario=<?= $usuario['idusuario'] ?>"> <!-- Corrigido para pegar o ID do usuário -->
                    <img src="uploads/<?= $usuario['foto'] ?>" alt="Avatar" class="profile-img1">
                </a>
                <div class="usuario-texto">
                    <strong><?= htmlspecialchars($usuario['apelido']) ?></strong>
                    <small><?= htmlspecialchars($usuario['email'] ?? '') ?></small>
                </div>
            </div>
            <a href="seguir.php?idseguido=<?= $usuario['idusuario'] ?>&redirect=sugestao" class="seguir-btn">
                Adicionar
            </a>
        </div>
    <?php endforeach; ?>
</div>




</div>

<?php
include "incs/footer.php";
?>

<script src="script.js"></script>
</body>

</html>