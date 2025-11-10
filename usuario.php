<?php
include __DIR__ . "/incs/nav.php";
require_once __DIR__ . "/src/UsuarioDAO.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title><?= $_SESSION['apelido'] ?> • LUMIX</title>

  <style>
    :root {
      --bg-light: #f9f9f9;
      --bg-dark: #000;
      --text-dark: #0f1419;
      --text-light: #536471;
      --primary: #1d9bf0;
      --border: rgba(0,0,0,0.1);
    }
    .profile-container {
      max-width: 80%;
      margin: 0 auto;
      background: #fff;
      border-left: 1px solid var(--border);
      border-right: 1px solid var(--border);
      min-height: 100vh;
    }

    /* --- Header --- */
    .cover {
      width: 100%;
      height: 220px;
      background: linear-gradient(135deg, #1d9bf0, #4a00e0);
      position: relative;
    }

    .avatar {
      position: absolute;
      bottom: -60px;
      left: 16px;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid #fff;
      background-color: #ccc;
      object-fit: cover;
    }

    .profile-header {
      position: relative;
      padding: 80px 16px 16px 16px;
      border-bottom: 1px solid var(--border);
    }

    .profile-header h2 {
      font-weight: 700;
      font-size: 22px;
      margin: 0;
    }

    .profile-header .handle {
      color: var(--text-light);
      font-size: 15px;
    }

    .profile-header p {
      margin-top: 8px;
      font-size: 15px;
    }

    .edit-btn {
      position: absolute;
      right: 16px;
      top: 16px;
      border-radius: 50px;
      font-weight: 600;
      border: 1px solid var(--border);
    }

    .stats {
      display: flex;
      gap: 20px;
      margin-top: 10px;
      font-size: 15px;
    }

    .stats span {
      font-weight: 600;
      color: var(--text-dark);
    }

    /* Tabs */
    .tabs {
      display: flex;
      justify-content: space-around;
      border-bottom: 1px solid var(--border);
      background: #fff;
    }

    .tabs button {
      flex: 1;
      padding: 14px 0;
      font-weight: 600;
      border: none;
      background: transparent;
      color: var(--text-light);
      transition: color 0.2s ease;
    }

    .tabs button.active {
      color: var(--text-dark);
      border-bottom: 3px solid var(--primary);
    }

    /* Posts */
    .post {
      border-bottom: 1px solid var(--border);
      padding: 16px;
      display: flex;
      gap: 12px;
      transition: background 0.2s ease;
    }

    .post:hover {
      background-color: rgba(0,0,0,0.03);
    }

    .post img {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
    }

    .post-content strong {
      display: block;
      font-weight: 600;
      color: var(--text-dark);
    }

    .post-content small {
      color: var(--text-light);
    }

    .post-content p {
      margin: 6px 0 0;
      font-size: 15px;
    }

    .actions {
      display: flex;
      gap: 40px;
      margin-top: 10px;
      color: var(--text-light);
      font-size: 14px;
    }

    .actions span:hover {
      color: var(--primary);
      cursor: pointer;
    }

    @media (max-width: 600px) {
      .avatar {
        width: 100px;
        height: 100px;
      }
      .edit-btn {
        font-size: 14px;
        padding: 6px 14px;
      }
    }
    .layout {
  display: grid;
  grid-template-columns: 260px 1fr 350px;
  width: 100vw;          /* ocupa toda a largura da tela */
  height: 100vh;         /* ocupa toda a altura da tela */
  margin: 0;             /* remove o centralizado */
  border-left: none;     /* opcional: remove as bordas laterais externas */
  border-right: none;
}

  </style>
</head>

<body>
  <div class="profile-container">
    <div class="cover">
      <img src="uploads/<?= $_SESSION['foto'] ?>" alt="Foto de perfil" class="avatar">
    </div>

    <div class="profile-header">
      <button class="btn btn-light edit-btn">Editar Perfil</button>
      <h2><?= $_SESSION['apelido'] ?></h2>
      <div class="handle">@<?= strtolower($_SESSION['apelido']) ?></div>
      <p>🌍 Brasil • Designer • Criador de interfaces modernas</p>

      <div class="stats">
        <div><span>234</span> seguindo</div>
        <div><span>3.1k</span> seguidores</div>
      </div>
    </div>

    <div class="tabs">
      <button class="active">Posts</button>
      <button>Respostas</button>
      <button>Curtidas</button>
    </div>

    <!-- Feed -->
    <div class="post">
      <img src="uploads/<?= $_SESSION['foto']?>" alt="Avatar">
      <div class="post-content">
        <strong><?= $_SESSION['apelido'] ?> <small>@<?= strtolower($_SESSION['apelido']) ?> · 2h</small></strong>
        <p>Explorando novas ideias para a interface da LUMIX 👀✨</p>
        <div class="actions">
          <span>💬 12</span>
          <span>🔁 4</span>
          <span>❤️ 89</span>
        </div>
      </div>
    </div>

    <div class="post">
      <img src="uploads/<?= $_SESSION['foto']?>" alt="Avatar">
      <div class="post-content">
        <strong><?= $_SESSION['apelido'] ?> <small>@<?= strtolower($_SESSION['apelido']) ?> · Ontem</small></strong>
        <p>Adicionei um modo escuro automático à nova versão da LUMIX 🌙</p>
        <div class="actions">
          <span>💬 23</span>
          <span>🔁 7</span>
          <span>❤️ 120</span>
        </div>
      </div>
    </div>

    <div class="post">
      <img src="uploads/<?= $_SESSION['foto']?>" alt="Avatar">
      <div class="post-content">
        <strong><?= $_SESSION['apelido'] ?> <small>@<?= strtolower($_SESSION['apelido']) ?> · 3 dias</small></strong>
        <p>Testando microinterações com animações suaves e feedback visual 💡</p>
        <div class="actions">
          <span>💬 8</span>
          <span>🔁 2</span>
          <span>❤️ 56</span>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
