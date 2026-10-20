<?php
include "incs/nav.php";
require_once "src/UsuarioDAO.php";
require_once "src/SeguidoDAO.php"; // ✅ necessário para verificar se já segue

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idusuario = $_SESSION['idusuario'] ?? null;

$apelido = $_GET['apelido'] ?? '';


if (!$idusuario) {
    header("Location: login.php");
    exit;
}


$usuarios = UsuarioDAO::buscarUsuarios($idusuario, $apelido);
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Sugestão</title>
</head>

<body>
    <div class="container my-5">

        <?php if (isset($_GET['msg'])) { ?>
            <div class="alert-custom">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php } ?>

        <?php if (!empty($apelido)) { ?>
            <h4 class="text-center mb-4">Resultados da busca por “<?= htmlspecialchars($apelido) ?>”</h4>
        <?php } ?>

        <div class="sugestoes-lista">
            <?php foreach ($usuarios as $usuario) { ?>
                <?php
                if ($usuario['idusuario'] == $idusuario) continue; // pula o proprio usuário

                // ve se o usuario ja segue a pss
                $jaSegue = SeguidoDAO::verificarSeSegue($idusuario, $usuario['idusuario']);
                ?>

                <div class="usuario-item">
                    <div class="usuario-info ">
                        <a href="perfil.php?idusuario=<?= $usuario['idusuario'] ?>">
                            <img src="uploads/<?= htmlspecialchars($usuario['foto']) ?>" alt="Avatar" class="profile-img1 rounded-circle me-2" width="48" height="48">
                        </a>
                        <div class="usuario-texto">
                            <strong><?= htmlspecialchars($usuario['apelido']) ?></strong><br>
                            <small><?= htmlspecialchars($usuario['email']) ?></small>
                        </div>
                    </div>

                    <button
                        class="seguir-btn <?= $jaSegue ? 'btn-secondary seguindo' : 'btn-primary' ?>"
                        data-id="<?= $usuario['idusuario'] ?>"
                        data-sugestao="true">
                        <?= $jaSegue ? 'Seguindo' : 'Seguir' ?>
                    </button>
                </div>
            <?php } ?>
        </div>

    </div>

    <?php include "incs/footer.php"; ?>

    <script src="script.js"></script>
</body>

</html>