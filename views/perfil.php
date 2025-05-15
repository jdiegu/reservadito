<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Reservadito</title>
    <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>

    <?php include "../includes/header.php"; ?>

    <?php
    include "../includes/conexion.php";

    $user_id = $_SESSION["user_id"];
    $sql = "SELECT nombre, apPaterno, apMaterno, numTelefonico, fotoPerfil, tipoUsuario, correoInstitucional FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    ?>

    <main>
        <?php if ($user): ?>
            <section class="profile">
                <img src="<?php echo htmlspecialchars($user["fotoPerfil"]) ?: '../assets/media/default-user.png'; ?>"
                    alt="Foto de perfil" class="profile-pic">
                <h2><?php echo htmlspecialchars($user["nombre"] . " " . $user["apPaterno"] . " " . $user["apMaterno"]); ?>
                </h2>
                <p><strong>No. de control:</strong> <?php echo htmlspecialchars($user_id); ?></p>
                <p><strong>No. telefónico:</strong> <?php echo htmlspecialchars($user["numTelefonico"]); ?></p>
                <p><strong>Correo: </strong> <?php echo htmlspecialchars($user["correoInstitucional"]); ?></p>
                <button onclick="window.location.href='../models/logout.php'">Cerrar sesión</button>
            </section>
        <?php else: ?>
            <p>Error: No se encontró información del usuario.</p>
        <?php endif; ?>
    </main>

    <?php include '../includes/footer.php'; ?>

</body>

</html>