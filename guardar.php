<?php
include "incs/nav.php";
require_once "src/UsuarioDAO.php";
require_once "src/SeguidoDAO.php";
require_once "src/CurtidaDAO.php";
require_once "src/PostagemDAO.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$idusuario = $_SESSION['idusuario'];
$postagens = PostagemDAO::listarTimeline($idusuario);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Posts</title>
  <style>
   
  </style>
</head>

<body>

  <?php foreach ($postagens as $postagem):
    $curtiu = CurtidaDAO::jaCurtiu($idusuario, $postagem['idpostagens']);
    $totalCurtidas = CurtidaDAO::contarCurtidas($postagem['idpostagens'])['total'];
  ?>
    <div class="post-card1">
      <div class="post-header1">
        <img src="uploads/<?= $_SESSION['foto'] ?>" alt="Avatar" class="profile-img1">
        <div class="user-info1"><strong><?= $_SESSION['apelido'] ?></strong></div>
      </div>

      <div class="post-text1"><?= htmlspecialchars($postagem['texto']) ?></div>

      <?php if (!empty($postagem['foto'])): ?>
        <div class="post-image1">
          <img src="uploads/<?= $postagem['foto'] ?>" alt="Imagem do post">
        </div>
      <?php endif; ?>

      <div class="stats1"><?= $totalCurtidas ?> Curtidas</div>

      <div class="actions1">
        <div class="action-btn1">
          <a href="#" class="btn-curtir" data-id="<?= $postagem['idpostagens'] ?>">
            <i class="<?= $curtiu ? 'fa-solid' : 'fa-regular' ?> fa-heart"></i> Curtir
          </a>
        </div>
        <div class="action-btn1"><i class="fa-regular fa-comment"></i> Comentar</div>
        <div class="action-btn1"><i class="fa-solid fa-share"></i> Compartilhar</div>
      </div>
    </div>
  <?php endforeach; ?>

  <script>
    document.querySelectorAll('.btn-curtir').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const idpost = this.dataset.id;
        const icon = this.querySelector('i');
        const stats = this.closest('.post-card1').querySelector('.stats1');

        fetch('curtir.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'idpost=' + encodeURIComponent(idpost)
          })
          .then(res => res.json())
          .then(data => {
            stats.textContent = data.totalCurtidas + ' Curtidas';
            if (data.status === 'curtido') {
              icon.classList.remove('fa-regular');
              icon.classList.add('fa-solid');
            } else {
              icon.classList.remove('fa-solid');
              icon.classList.add('fa-regular');
            }
          })
          .catch(err => console.error(err));
      });
    });
  </script>

</body>

</html>