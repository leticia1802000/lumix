<?php
include "incs/nav.php";
require_once "src/UsuarioDAO.php";
require_once "src/SeguidoDAO.php";
require_once "src/CurtidaDAO.php";
require_once "src/PostagemDAO.php";
require_once "src/MusicaDAO.php";
require_once "src/CantorDAO.php";

// Buscar todos os cantores
$cantores = CantorDAO::buscarCantor(0, '');


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$idusuario = $_GET['idusuario'] ?? $_SESSION['idusuario'];
$usuario = UsuarioDAO::buscarUsuarioId($idusuario);
$postagens = PostagemDAO::listarPorUsuario($idusuario);
$musicas = MusicaDAO::listarMusicas($usuario['idusuario']);
// === TROCA DE FOTO DE PERFIL ===
if ($idusuario == $_SESSION['idusuario'] && isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
  $ext = pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION);
  $novoNome = uniqid('perfil_') . '.' . $ext;
  $destino = 'uploads/' . $novoNome;

  if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $destino)) {
    // Atualiza no banco
    UsuarioDAO::atualizarFoto($idusuario, $novoNome);
    // Atualiza sessão
    $_SESSION['foto'] = $novoNome;
    // Recarrega página
    header("Location: perfil.php?idusuario=" . $idusuario);
    exit;
  } else {
    echo '<p style="color:red;text-align:center;">Erro ao enviar a imagem.</p>';
  }
}


?>


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Lumix - Perfil</title>
</head>
<style>
  .cover {
    width: 100%;
    max-width: 950px;
    height: 260px;
    background-image: url('<?php echo "uploads/" . $usuario['fotocapa']; ?>');
    background-size: cover;
    background-position: center;
    margin: 10px auto 0;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    z-index: -1;
  }

  .containerPosts1 {
    width: 75%;
    max-width: 950px;
    margin: 20px auto 60px;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text);
    position: relative;
    z-index: 2;
  }

  .perfil-bloco {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    width: 100%;
    text-align: right;
  }

  .perfil-bloco .info {
    text-align: left;
    align-self: flex-start;
  }

  .playlist-box h3 {
    text-align: center;
    font-weight: 600;
    font-size: 1.5rem;
    color: #333;
    border-bottom: 3px solid #2043b4;
    display: inline-block;
    padding-bottom: 5px;
    margin: 0 auto 20px;
  }

  .profile-header,
  .stats {
    width: 100%;
  }

  /* Container da playlist */
  .playlist-box {
    background-color: white;
    /* fundo escuro */
    padding: 10px;
    border-radius: 10px;
    margin-left: 50px;
    text-align: center;
  }

  /* Lista de músicas */
  .playlist-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  /* Card de música */
  .pl-card {
    display: flex;
    align-items: center;
    background-color: rgba(203, 197, 197, 0.85);
    /* transparente, elegante */
    border-radius: 8px;
    padding: 8px;
    transition: background 0.2s;
  }

  .pl-card:hover {
    background-color: #5412a978;
  }

  /* Capa da música */
  .pl-cover {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    background-color: #555;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .pl-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Mantém proporção sem deformar */
  }

  /* Info da música */
  .pl-info {
    flex: 1;
    margin-left: 10px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .pl-info strong {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    /* Evita texto cortando layout */
    color: #000000ff;
  }

  .pl-info small {
    color: #aaa;
    font-size: 0.8rem;
  }

  .pl-controls button {
    background: none;
    border: none;
    color: #000000ff;
    cursor: pointer;
    font-size: 1rem;
  }
</style>

<body>
  <div class="container-fluid px-0 noSelect">
    <div class="row gx-0">
      <!-- Coluna lateral estreita -->
      <div class="col-2">
        <div class="playlist-box">
          <h3>Playlist</h3>
          <div class="playlist-list">
            <?php foreach ($musicas as $musica): ?>
              <div class="pl-card">
                <div class="pl-cover">
                  <?php if (!empty($musica['fotomusica'])): ?>
                    <img src="uploads/<?= htmlspecialchars($musica['fotomusica']) ?>" alt="Capa da música" />
                  <?php else: ?>
                    <div class="pl-placeholder"></div>
                  <?php endif; ?>
                </div>
                <div class="pl-info">
                  <strong><?= htmlspecialchars($musica['nomemusica']) ?></strong>
                  <small><?= htmlspecialchars($musica['cantormusica']) ?></small>
                </div>
                <div class="pl-controls">
                  <button>⏮</button>
                  <button>▶</button>
                  <button>⏭</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <!-- Coluna central com capa + perfil + posts -->
      <div class="col-md-8 d-flex flex-column align-items-center">
        <div class="cover"></div>

        <section class="containerPosts1">
          <div class="perfil-bloco">
            <section class="profile-header">
              <?php if ($idusuario == $_SESSION['idusuario']): ?>
                <form id="formFotoPerfil" action="atualizar-foto.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="idusuario" value="<?= $usuario['idusuario'] ?>">

                  <img src="uploads/<?= $usuario['foto'] ?>" alt="Avatar" id="fotoPerfil" class="avatar" style="cursor:pointer;">
                  <input type="file" id="inputFoto" name="foto" accept="image/*" style="display:none;">
                </form>
              <?php else: ?>
                <img src="uploads/<?= $usuario['foto'] ?>" alt="Avatar" class="avatar">
              <?php endif; ?>
              <div class="info">
                <h1 class="name">
                  <?= $usuario['apelido'] ?>
                  <?php
                  if ($usuario['genero'] === 'Feminino') {
                    echo '<i class="fas fa-venus ms-2" title="Feminino"></i>';
                  } elseif ($usuario['genero'] === 'Masculino') {
                    echo '<i class="fas fa-mars ms-2" title="Masculino"></i>';
                  } else {
                    echo '<i class="fas fa-genderless ms-2" title="Outro"></i>';
                  }
                  ?>
                </h1>


                <div class="username"><?= $usuario['email'] ?></div>
                <div class="tags">
                  <span class="tag2"><?= $usuario['ocupacao'] ?></span>


                </div>
                <div class="meta">Membro desde Janeiro 2023</div>
                <div class="actions">
                  <button class="btn btn-duplo" data-bs-toggle="modal" data-bs-target="#modalCompartilhar2">Adicione sua música</button>
                </div>
              </div>
            </section>

            <div class="stats">
              <?php
              $seguidor = SeguidoDAO::contarSeguidores($_SESSION['idusuario']);
              $seguido = SeguidoDAO::contarSeguidos($_SESSION['idusuario']);
              ?>
              <div class="stat">
                <div class="num"><?= $seguidor['seguidores'] ?></div>
                <div class="label">Seguidores</div>
              </div>
              <div class="stat">
                <div class="num"><?= $seguido['seguidos'] ?></div>
                <div class="label">Seguindo</div>
              </div>
              <div class="stat">
                <div class="num">23</div>
                <div class="label">Playlists</div>
              </div>
              <div class="stat">
                <div class="num"> <?= $usuario['cantorFav'] ?></div>
                <div class="label">Cantor(a) Favorito(a)</div>
              </div>
            </div>
          </div>

          <div class="feed">
            <?php
            foreach ($postagens as $postagem):
              $curtiu = CurtidaDAO::jaCurtiu($idusuario, $postagem['idpostagens']);
              $totalCurtidas = CurtidaDAO::contarCurtidas($postagem['idpostagens'])['total'];
            ?>
              <div class="post-card1">
                <div class="post-header1">
                  <img src="uploads/<?= $usuario['foto'] ?>" alt="Avatar" class="profile-img1">
                  <div class="user-info1"><strong><?= $usuario['apelido'] ?></strong></div>
                  <div class="tag2"><strong> Sentindo-se <?= $postagem['sentimento'] ?></strong></div>
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


                  <!-- Botão excluir continua dentro do if -->
                  <?php if ($postagem['idusuario'] == $usuario['idusuario']): ?>
                    <div class="action-btn1">
                      <a href="excluir-postagem.php?idpostagens=<?= $postagem['idpostagens'] ?>" class="btn-excluir">
                        <i class="fa-solid fa-trash"></i> Excluir
                      </a>
                    </div>
                  <?php endif; ?>

                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- Modal de Compartilhamento -->
  <div class="modal fade" id="modalCompartilhar2" tabindex="-1" aria-labelledby="modalCompartilharLabel">
    <div class="modal-dialog">
      <div class="modal-content custom-modal">
        <div class="modal-header border-0">
          <h5 class="modal-title text-white" id="modalCompartilharLabel">Criar Nova Postagem</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form action="cadastra-musica.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idusuario" value="<?= $usuario['idusuario'] ?>">

            <div class="grupo-input1 mb-3">
              <label class="form-label text-white">Nome da música</label>
              <textarea name="nomemusica" class="input-field" rows="4" placeholder="Escreva algo..." required></textarea>
            </div>

            <div class="row">
              <div class="col grupo-input1 mb-3">
                <input list="cantores" id="cantormusica" name="cantormusica" class="form-control" placeholder="Digite o cantor..." required>
                <div id="listaCantores" class="lista-dropdown"></div>
                <datalist id="cantores">
                  <?php foreach ($cantores as $c): ?>
                    <option value="<?= htmlspecialchars($c['nome']) ?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>

            <div class="grupo-input1 col-6">
              <label class="form-label text-white">Foto da música</label>
              <div class="upload2">
                <div class="preview2" id="imgPreview">+</div>
                <input class="file-input1" name="fotomusica" type="file" accept="image/*" />
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

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>