<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras - Reservadito</title>
    <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <?php
    $id_usuario = $_SESSION["user_id"];

    include "../includes/conexion.php";
    $sql = "SELECT
    p.id_pedido AS pedido,
    pl.nombrePlatillo AS platillo,
    pl.imagen AS imagen,
    b.nombre_bebida AS bebida,
    a.nombre_acomp AS acompanamiento,
    p.costo_total AS precio,
    p.indicaciones AS indi,
    p.fecha_pedido AS fecha,
    p.hora_entrega AS hora,
    p.estado AS estado
    FROM pedidos p
    JOIN platillos pl ON p.id_platillo = pl.id_platillo
    JOIN bebidas b ON p.id_bebida = b.id_bebida
    JOIN acompanamiento a ON p.id_acompanamiento = a.id_acompanamiento
    WHERE p.id_usuario = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>

    <main>
        <h1>Pedidos realizados</h1>
        <section class="menu-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<article class="menu-item">';
                    echo '<img src="' . htmlspecialchars($row["imagen"]) . '" alt="Platillo">';
                    echo '<div class="menu-info">';
                    echo '<h2>' . htmlspecialchars($row["platillo"]) . '</h2>';
                    echo '<p><strong>Bebida:</strong> ' . htmlspecialchars($row["bebida"]) . '</p>';
                    echo '<p><strong>Acompañamiento:</strong> ' . htmlspecialchars($row["acompanamiento"]) . '</p>';
                    echo '<p><strong>Indicaciones:</strong> ' . htmlspecialchars($row["indi"]) . '</p>';

                    echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . ' | ';
                    echo '<strong>Fecha:</strong> ' . htmlspecialchars($row["fecha"]) . ' | ';
                    echo '<strong>Hora:</strong> ' . htmlspecialchars($row["hora"]) . '</p>';

                    if (number_format($row["estado"]) == 0) {
                        echo '<strong>Estado: </strong>Pendiente</p>';
                    } else {
                        if (number_format($row["estado"]) == 1) {
                            echo '<strong>Estado: </strong>Listo para entregar</p>';
                        } else {
                            if (number_format($row["estado"]) == 2) {
                                echo '<strong>Estado: </strong>Entregado</p>';
                            } else {
                                echo '<strong>Estado: </strong>Cancelado</p>';
                            }
                        }

                    }

                    echo '<form action="resena.php" method="POST">';
                    echo '<input type="hidden" name="pedido" value="' . $row["pedido"] . '">';
                    echo '<button type="submit" class="btn-resena"> Añadir reseña </button>';
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