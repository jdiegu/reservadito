<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: views/login.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$tipoUsuario = $_SESSION["tipo"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservadito</title>
    <link rel="stylesheet" href="assets/css/estilo-general.css">
</head>

<body>

    <header class="header-container">
        <div class="logo">
            <img src="assets/media/logo.png" alt="Logo">
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Inicio</a></li>

                <?php if ($tipoUsuario === 'cliente'): ?>
                    <li><a href="views/menu.php">Menú</a></li>
                    <li><a href="views/compras.php">Compras</a></li>
                <?php endif; ?>

                <?php if ($tipoUsuario === 'admin'): ?>
                    <li class="dropdown">
                        <a href="">Pedidos ▾</a>
                        <ul class="dropdown-content">
                            <li><a href="views/pedidos-pendientes.php">Pedidos pendientes</a></li>
                            <li><a href="views/pedidos-por-entregar.php">Pedidos por entregar</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="">Administrar ▾</a>
                        <ul class="dropdown-content">
                            <li><a href="views/admin-platillo.php">Platillos</a></li>
                            <li><a href="views/admin-bebida.php">Bebidas</a></li>
                            <li><a href="views/admin-acomp.php">Acompañamientos</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li> <a href="views/perfil.php">Perfil</a></li>
            </ul>
        </nav>

    </header>

    <main>
        <h1>BIENVENIDO ¿Qué desea ordenar?</h1>
        <section class="carousel">
            <img src="" alt="Falta foto">
        </section>
        <p>La cafetería de confianza para toda la comunidad del ITD</p>
        <p>¿Vas con el tiempo contado para tus clases? <br>
            No te preocupes, realiza tu pedido para disfrutarlo en el establecimiento o llevártelo.</p>
        <section class="publicidad">
            <h2>Puede interesarte</h2>
            <img src="assets/media/publi.jpg" alt="Publicidad de eventos">
        </section>
    </main>

    <footer>
        <p>Queja o sugerentias contactanos</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            }

            console.log("se notifico");

            setInterval(() => {
                fetch("models/notificaciones/verificar_notificacion.php")
                    .then(res => res.json())
                    .then(data => {
                        if (data.mensaje && Notification.permission === "granted") {
                            new Notification("Reservadito", {
                                body: data.mensaje,
                                icon: "assets/media/logo.png"
                            });
                        }
                    });
            }, 5000);
        });

    </script>
</body>

</html>