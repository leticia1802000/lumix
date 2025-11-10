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
$musicas = MusicaDAO::listarMusicas();


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$idusuario = $_SESSION['idusuario'];
$postagens = PostagemDAO::listarTimeline($idusuario);
?>

<style>
  .cover {
    width: 100%;
    max-width: 950px;
    height: 260px;
    background-image: url('<?php echo "uploads/" . $_SESSION['fotocapa']; ?>');
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


  .profile-header,
  .stats {
    width: 100%;
  }


  
  


 
.playlist-box h3 {
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.playlist-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.pl-card {
  display: flex;
  align-items: center;
  background-color: #c8c1c1ff;
  border-radius: 12px;
  padding: 10px;
  gap: 12px;
}

.pl-cover {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  overflow: hidden;
  background-color: #28a745;
  flex-shrink: 0;
}

.pl-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.pl-placeholder {
  width: 100%;
  height: 100%;
  background-color: #ccc;
}

.pl-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.pl-info strong {
  font-size: 1rem;
  color: #dc3545;
}

.pl-info small {
  font-size: 0.85rem;
  color: #007bff;
}

.pl-controls {
  display: flex;
  gap: 8px;
}

.pl-controls button {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #333;
}

</style>

<body>
 <div class="container-fluid px-0">
  <div class="row gx-0">
    <!-- Coluna lateral estreita -->
<div class="col-md-2">
  <div class="sugestoes-container2">
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
</div>




      <!-- Coluna central com capa + perfil + posts -->
      <div class="col-md-8 d-flex flex-column align-items-center">
        <div class="cover"></div>

        <section class="containerPosts1">
          <div class="perfil-bloco">
            <section class="profile-header">
              <img src="uploads/<?= $_SESSION['foto'] ?>" alt="Avatar" class="avatar">
              <div class="info">
                <h1 class="name"><?= $_SESSION['apelido'] ?></h1>
                <div class="username"><?= $_SESSION['email'] ?></div>
                <div class="tags">
                  <span class="tag2"><?= $_SESSION['ocupacao'] ?></span>
                </div>
                <div class="meta">Membro desde Janeiro 2023</div>
                <div class="actions">
<button class="btn btn-duplo" data-bs-toggle="modal" data-bs-target="#modalCompartilhar2">Compartilhar</button>
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
                <div class="num">1.240h</div>
                <div class="label">Ouvidas</div>
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
                  <img src="uploads/<?= $_SESSION['foto'] ?>" alt="Avatar" class="profile-img1">
                  <div class="user-info1"><strong><?= $_SESSION['apelido'] ?></strong></div>
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
                  <div class="action-btn1"><i class="fa-regular fa-comment"></i> Comentar</div>
                  <div class="action-btn1"><i class="fa-solid fa-share"></i> Compartilhar</div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      </div>
    </div>
  </div>
<!-- Modal de Compartilhamento -->
<div class="modal fade" id="modalCompartilhar2" tabindex="-1" aria-labelledby="modalCompartilharLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content custom-modal">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white" id="modalCompartilharLabel">Criar Nova Postagem</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form action="cadastra-musica.php" method="POST" enctype="multipart/form-data">
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="script.js"></script>
</body>