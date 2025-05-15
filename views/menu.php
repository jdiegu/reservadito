<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Reservadito</title>
    <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>
    <?php
    include "../includes/header.php";
    ?>

    <?php
    include '../includes/conexion.php';
    $sql = "SELECT id_platillo, nombrePlatillo, precio, tiempoPreparacion, imagen FROM platillos WHERE disponibilidad = 1";
    $result = $conn->query($sql);
    ?>

    <main>
        <h1>¿Qué desea ordenar?</h1>
        <section class="menu-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<article class="menu-item">';
                    echo '<img src="' . htmlspecialchars($row["imagen"]) . '" alt="Platillo">';
                    echo '<div class="menu-info">';
                    echo '<h2>' . htmlspecialchars($row["nombrePlatillo"]) . '</h2>';
                    echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . '</p>';
                    echo '<p><strong>Tiempo estimado de preparación:</strong> ' . htmlspecialchars($row["tiempoPreparacion"]) . ' min</p>';

                    echo '<form action="platillo.php" method="POST">';
                    echo '<input type="hidden" name="id" value="' . $row["id_platillo"] . '">';
                    echo '<button type="submit" class="btn-ordenar">Ordenar</button>';
                    echo '</form>';

                    echo '</div>';
                    echo '</article>';
                }
            } else {
                echo "<p>No hay platillos disponibles en este momento.</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>

    <?php include '../includes/footer.php' ?>

</body>

</html>