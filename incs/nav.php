<?php
include "incs/valida-sessao.php";
?>
<!doctype html>


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="img/2logo.png" type="image/png">


    <link rel="stylesheet" href="css/style.css">
</head>


<section class="navCustom noSelect" >
    <div class="logomarca">
        <a href="site.php">
            <img src="img/logo1.png" alt="Logo" width="90" height="auto">
        </a>

        <div>
            <div class="logomarca2">Lumix</div>
            <small><?= $_SESSION['apelido'] ?> - <?= $_SESSION['email'] ?></small>
        </div>
    </div>


    <form class="pesquisar" role="search" action="sugestao.php">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" />
        </svg>
        <input placeholder="Buscar pessoas, posts ou hashtags" aria-label="Buscar" name="apelido" autocomplete="off" />
        <button type="login-btn">Buscar</button>

    </form>

    <div style="display:flex; gap:10px; align-items:center;">

        <button id="themeToggle" class="btn tema" type="button" title="Alternar tema">
            <span class="material-icons">light_mode</span>
        </button>

        <a href="logout.php" class="nav btn tema">Sair</a>

    </div>


</section>