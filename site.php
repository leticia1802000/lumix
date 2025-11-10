<?php

include "incs/nav.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "src/UsuarioDAO.php";
require_once "src/SeguidoDAO.php";
require_once "src/CurtidaDAO.php";
require_once "src/PostagemDAO.php";



$idusuario = $_SESSION['idusuario'];


$sentimento = isset($_GET['sentimento']) ? $_GET['sentimento'] : 'neutro'; // valor padrão "neutro"

$sentimento = $_GET['sentimento'] ?? 'todos';

if ($sentimento === 'todos') {
  $postagens = PostagemDAO::listarTimeline($idusuario);
} else {
  $postagens = PostagemDAO::listarPorSentimento($sentimento);
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Rede Social</title>
</head>

<body>
  <div class="maincontainer container ">
    <div class="row justify-content-between g-0">

      <!-- Perfil lateral -->
      <aside class="perfil-lateral col-lg-4 col-md-4 col-12">
        <div class="card cardPerfil">
          <div class="profile">
            <img src="uploads/<?= $_SESSION['foto'] ?>" alt="" class="avatarPerfil">
            <div class="dadosUsuario">
              <h5 class="card-title fw-bold"><?= $_SESSION['apelido'] ?></h5>
              <small class="tag2"><?= $_SESSION['ocupacao'] ?></small>
            </div>
          </div>

          <div class="perfil-stats">
            <?php
            $seguidor = SeguidoDAO::contarSeguidores($_SESSION['idusuario']);
            $seguido = SeguidoDAO::contarSeguidos($_SESSION['idusuario']);
            $post = PostagemDAO::contarPostagens($_SESSION['idusuario']);
            ?>
            <div>
              <div class="numero"><?= $post['totalposts'] ?></div><small>Posts</small>
            </div>
            <div>
              <div class="numero"><?= $seguidor['seguidores'] ?></div><small>Seguidores</small>
            </div>
            <div>
<div class="numero" id="contador-seguido"><?= $seguido['seguidos'] ?></div><small>Seguindo</small>
            </div>
          </div>

          <div class="perfil-acoes">
            <button class="btn editar" onclick="window.location.href='perfil.php?idusuario=<?= $_SESSION['idusuario'] ?>'">Ver perfil</button>
          </div>
        </div>

        <!-- Pessoas que você segue -->
        <div class="sugestoes-container col-3">
          <div class="sugestoes-topo">
            <h3>Pessoas que voce segue</h3>
          </div>
          <div class="usuarios-lista">
            <?php
            $seguidos = SeguidoDAO::listarSeguidos($idusuario);
            foreach ($seguidos as $s): ?>
              <div class="usuario-item">
                <div class="usuario-info">
                  <img src="uploads/<?= htmlspecialchars($s['foto'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($s['apelido']) ?>" class="usuario-foto">
                  <div class="usuario-texto"><strong><?= htmlspecialchars($s['apelido']) ?></strong><small><?= htmlspecialchars($s['email']) ?></small></div>
                </div>
                <button class="seguir-btn seguindo" data-id="<?= $s['idusuario'] ?>">Seguindo</button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>

      <!-- Feed principal -->
      <section class="feedprincipal col-lg-4 col-md-6 col-12" aria-label="Feed de posts">
        <!-- Botões de sentimentos -->
        <div class="filtro-sentimentos mb-3">
          <a href="?sentimento=feliz" class="btn tag">Feliz</a>
          <a href="?sentimento=triste" class="btn tag">Triste</a>
          <a href="?sentimento=bravo" class="btn tag">Bravo</a>
          <a href="?sentimento=neutro" class="btn tag">Neutro</a>
          <a href="?sentimento=todos" class="btn tag">Todos</a>
        </div>

        <!-- Card de criação de post -->
        <div class="cardpost col-4">
          <div class="d-flex align-items-center justify-content-between">
            <label class="label postagem mb-0" style="flex: 1; margin-right: 10px;">
              No que você está pensando?
            </label>
            <button type="button" class="btn editar" data-bs-toggle="modal" data-bs-target="#modalPost">
              <i class="fa-solid fa-pen fa-lg"></i>
            </button>
          </div>
        </div>

        <!-- Modal de criação -->
        <div class="modal fade" id="modalPost" tabindex="-1" aria-labelledby="modalPostLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content custom-modal">
              <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="modalPostLabel">Criar Nova Postagem</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <form action="processa-postagem.php" method="POST" enctype="multipart/form-data">
                  <div class="grupo-input1 mb-3">
                    <label class="form-label text-white">Texto</label>
                    <textarea name="texto" class="input-field" rows="4" placeholder="Escreva algo..." required></textarea>
                  </div>
                  <div class="row">
                    <div class="col grupo-input1 mb-3">
                      <label for="basic-select-publico" class="form-label text-white">Visibilidade</label>
                      <select id="basic-select-publico" name="publico" class="input-field1">
                        <option value="Público">Público</option>
                        <option value="Privado">Privado</option>
                      </select>
                    </div>
                    <div class="col grupo-input1 mb-3">
                      <label for="basic-select-sentimento" class="form-label text-white">Sentimento</label>
                      <select id="basic-select-sentimento" name="sentimento" class="input-field1">
                        <option value="feliz">Feliz</option>
                        <option value="triste">Triste</option>
                        <option value="bravo">Bravo</option>
                        <option value="neutro" selected>Neutro</option>
                      </select>
                    </div>
                  </div>
                  <div class="grupo-input1 col-6">
                    <label class="form-label text-white">Foto do post</label>
                    <div class="upload2">
                      <div class="preview2" id="imgPreview">+</div>
                      <input class="file-input1" id="imgFile" name="foto" type="file" accept="image/*" />
                    </div>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button type="submit" class="login-btn">Enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Feed de posts -->
        <?php foreach ($postagens as $postagem):
          $curtiu = CurtidaDAO::jaCurtiu($idusuario, $postagem['idpostagens']);
          $totalCurtidas = CurtidaDAO::contarCurtidas($postagem['idpostagens'])['total'];

          // Verifica se o usuário logado segue o autor do post
          $segueAutor = SeguidoDAO::verificarSeSegue($idusuario, $postagem['idusuario']);
        ?>
          <div class="post-card1">
            <div class="post-header1">
              <img src="uploads/<?= $postagem['foto_usuario'] ?>" alt="Avatar" class="profile-img1">
              <div class="user-info1"><strong><?= $postagem['apelido'] ?></strong></div>
              <div class="tag2"><strong>Sentindo-se <?= $postagem['sentimento'] ?></strong></div>

              <!-- Botão de seguir aparece só se não for o próprio usuário e ele ainda não segue -->
             <!-- Botão de seguir aparece só se não for o próprio usuário e ele ainda não segue -->
<?php if ($postagem['idusuario'] != $idusuario && !$segueAutor): ?>
    <a href="#" class="seguir-btn" data-id="<?= $postagem['idusuario'] ?>">Seguir</a>
<?php endif; ?>

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
              <div class="action-btn1">

                <!-- botão que abre o modal de comentários -->
                <a href="#" class="btn-comentar"
                  data-idpostagens="<?= $postagem['idpostagens'] ?>"
                  data-bs-toggle="modal"
                  data-bs-target="#modalComentariosx<?= $postagem['idpostagens'] ?>">
                  <i class="fa-regular fa-comment"></i> Comentar
                </a>

              </div>



















              <div class="postagem" data-idpostagens="<?= $postagem['idpostagens'] ?>">
                <?php if ($postagem['idusuario'] == $_SESSION['idusuario']): ?>
                  <div class="action-btn1">
                    <a href="#" class="btn-excluir" data-idpostagens="<?= $postagem['idpostagens'] ?>">
                      <i class="fa-regular fa-trash-can"></i> Excluir
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              



























            </div>
          </div>
          <div class="modal fade" id="modalComentariosx<?= $postagem['idpostagens'] ?>" tabindex="-1" aria-labelledby="comentariosLabel<?= $postagem['idpostagens'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content custom-modal">
                <div class="modal-header border-0">
                  <h5 class="modal-title text-white" id="comentariosLabel<?= $postagem['idpostagens'] ?>">Comentários</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                  <!-- Lista de comentários -->
                  <div id="listaComentarios<?= $postagem['idpostagens'] ?>" class="comentarios-lista mb-3" style="max-height: 250px; overflow-y: auto;">
                    <p class="text-white-50">Carregando comentários...</p>
                  </div>

                  <!-- Campo de comentário -->
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Escreva um comentário..." id="inputComentario<?= $postagem['idpostagens'] ?>">
                    <button class="btn-enviar" data-idpostagens="<?= $postagem['idpostagens'] ?>">Enviar</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
      <!-- Sugestões à direita -->
      <aside class="col-lg-3 col-md-4 col-12">
        <div class="sugestoes-container">
          <?php if (isset($_GET['msg'])): ?>
            <div class="alert-custom"><?= htmlspecialchars($_GET['msg']) ?></div>
          <?php endif; ?>
          <div class="sugestoes-topo">
            <h3>Seguir pessoas novas</h3>
            <a href="sugestao.php" class="btn editar">Seguir</a>
          </div>
          <div class="usuarios-lista">
            <?php
            $usuarios = UsuarioDAO::listarUsuariosAleatorios(8);
            foreach ($usuarios as $u):
            ?>

              <?php if ($u['idusuario'] == $idusuario) continue; // pula o próprio usuário 
              ?>
              <div class="usuario-item">
                <div class="usuario-info">
                  <img src="uploads/<?= htmlspecialchars($u['foto'] ?? 'default.jpg') ?>"
                    alt="Foto de <?= htmlspecialchars($u['apelido']) ?>" class="usuario-foto">
                  <div class="usuario-texto">
                    <strong><?= htmlspecialchars($u['apelido']) ?></strong>
                    <small><?= htmlspecialchars($u['email']) ?></small>
                  </div>
                </div>

  <button class="seguir-btn" data-id="<?= $u['idusuario'] ?>">Seguir</button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>


    </div>
  </div>
  <?php
  include "incs/footer.php";
  ?>
  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>