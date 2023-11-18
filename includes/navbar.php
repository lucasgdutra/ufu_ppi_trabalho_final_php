<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Lembre-se de mim</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/global.css" />
    <?php
    if (isset($links) && is_array($links)) {
        foreach ($links as $link) {
            echo "<link rel='stylesheet' href='{$link}' />";
        }
    }
    ?>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand text-wrap" href="/">
                <img src="/img/logo.svg" class="img-fluid" alt="logomarca - imagem vetorizada de um panda deitado pela lateral" width="50" height="50" loading="lazy" decoding="async" />
                Lembre-se de mim - Jogo da memória
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/jogos') === 0) ? 'active' : ''; ?>" aria-current="page" href="/jogos">Jogar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/lista') === 0) ? 'active' : ''; ?>" href="/lista">Animais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/ranking') === 0) ? 'active' : ''; ?>" href="/ranking">Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/sobre') === 0) ? 'active' : ''; ?>" href="/sobre">Sobre</a>
                    </li>
                </ul>
                <?php if (isset($_SESSION['user_name'])) { ?>
                    <ul class="navbar-nav mb-2 mb-lg-0 justify-content-end">
                        <li class="dropdown">

                            <!-- If a user is logged in, display the username -->
                            <a class="nav-link dropdown-toggle py-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $_SESSION['profile_photo_path'] != null ? $_SESSION['profile_photo_path'] . ".webp" : "/img/avatar.webp"; ?>" class="img-fluid rounded" alt="foto de perfil" height="40" width="40" loading="lazy" decoding="async" id="profilePhoto">

                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>


                            </a>
                            <ul class="dropdown-menu">
                                <?php if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']) : ?>
                                    <li><a class="dropdown-item" href="/admin">Admin</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                <?php endif; ?>

                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>


                        </li>
                    </ul>
                <?php } else { ?>
                    <!-- If no user is logged in, show link to the login page -->

                    <ul class="navbar-nav mb-2 mb-lg-0 justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link" href="/login" role="button" aria-expanded="false">
                                Login
                            </a>
                        </li>
                    </ul>
                <?php } ?>

            </div>
        </div>
    </nav>