<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Debes iniciar sesión primero");
            window.location = "index.php";
        </script>
    ';
    session_destroy();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilos_inicio.css">
    <title>Bienvenido</title>
    <style>
        /* Tu CSS aquí, incluyendo el CSS actualizado que te proporcioné */
    </style>
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="assets/images/bg3.jpg" alt="Logo de la escuela">
            <h2 class="proyecto-de-redes">Proyecto de Redes</h2>
        </a>
        <nav>
            <a href="index.php" class="nav-link">Inicio</a>
            <a href="amigos.php" class="nav-link">Amigos</a>
            <a href="php/cerrar_sesion.php" class="nav-link">Cerrar sesión</a>
        </nav>
    </header>

    <div class="main-container">
        <div class="sidebar">
            <h2>Videos</h2>
            <video width="320" height="240" autoplay controls>
                <source src="assets/videos/mov_bbb.mp4" type="video/mp4">
                <source src="assets/videos/mov_bbb.ogv" type="video/ogg">
                Tu navegador no soporta el elemento de video
            </video>
        </div>

        <div class="content">
            <div class="welcome-message">
                <h1>¡Bienvenido al Proyecto de Redes!</h1>
            </div>
        </div>
    </div>
</body>
</html>
