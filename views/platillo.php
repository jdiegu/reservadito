<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Platillo - Reservadito</title>
    <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>

    <?php include "../includes/header.php" ?>

    <?php
    if (!isset($_POST['id'])) {
        echo "No se recibió ningún platillo.";
        exit();
    }

    $id_platillo = $_POST['id'];

    include '../includes/conexion.php';

    $sql = "SELECT * FROM platillos WHERE id_platillo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_platillo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Platillo no encontrado.";
        exit();
    }
    $platillo = $result->fetch_assoc();

    $sql = "SELECT id_bebida, nombre_bebida, precio FROM bebidas WHERE disponibilidad = 1";
    $result = $conn->query($sql);
    $bebidas = $result;

    $sql = "SELECT id_acompanamiento, nombre_acomp, precio FROM acompanamiento WHERE disponibilidad = 1";
    $result = $conn->query($sql);
    $acomp = $result;
    ?>

    <main>
        <section class="platillo-detalle">
            <img src="<?php echo htmlspecialchars($platillo['imagen']); ?>" alt="Imagen del platillo"
                class="imagen-platillo">
            <h1><?php echo htmlspecialchars($platillo['nombrePlatillo']); ?></h1>
            <p class="precio">MX$ <?php echo number_format($platillo['precio'], 2); ?></p>

            <form action="../models/pedido/insertar-pedido.php" method="POST">
                <input type="hidden" name="id_platillo" value="<?php echo $id_platillo; ?>">

                <label for="bebida">Bebida:</label>
                <select id="bebida" name="bebida">
                    <?php
                    if ($bebidas->num_rows > 0) {
                        while ($row = $bebidas->fetch_assoc()) {
                            echo '<option value="' . $row["id_bebida"] . '" data-precio="' . $row["precio"] . '">' . $row["nombre_bebida"] . ' - MX $' . $row["precio"] . '</option>';
                        }
                    }
                    ?>

                </select>

                <label for="acompanamiento">Acompañamiento:</label>
                <select id="acompanamiento" name="acompanamiento">

                    <?php
                    if ($acomp->num_rows > 0) {
                        while ($row = $acomp->fetch_assoc()) {
                            echo '<option value="' . $row["id_acompanamiento"] . '" data-precio="' . $row["precio"] . '">' . $row["nombre_acomp"] . ' - MX $' . $row["precio"] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="indicaciones">Indicaciones adicionales:</label>
                <textarea id="indicaciones" name="indicaciones" rows="3"></textarea>

                <button type="submit" id="agregarBtn" data-precio-platillo="<?php echo $platillo['precio']; ?>">
                    Agregar - MX$ <span id="precio-total"><?php echo number_format($platillo['precio'], 2); ?></span>
                </button>
            </form>
            <button class="BtnCancelar" onclick="window.location.href='menu.php'">Cancelar</button>
        </section>
    </main>

    <footer>
        <p>Quejas o sugerencias: <a href="#">contáctanos</a></p>
    </footer>

    <script>
        const bebidaSelect = document.getElementById('bebida');
        const acompSelect = document.getElementById('acompanamiento');
        const precioBase = parseFloat(document.getElementById('agregarBtn').dataset.precioPlatillo);
        const precioTotalSpan = document.getElementById('precio-total');

        function actualizarPrecio() {
            const bebidaPrecio = parseFloat(bebidaSelect.selectedOptions[0].dataset.precio) || 0;
            const acompPrecio = parseFloat(acompSelect.selectedOptions[0].dataset.precio) || 0;
            const total = precioBase + bebidaPrecio + acompPrecio;
            precioTotalSpan.textContent = total.toFixed(2);
        }

        bebidaSelect.addEventListener('change', actualizarPrecio);
        acompSelect.addEventListener('change', actualizarPrecio);

        window.addEventListener('DOMContentLoaded', actualizarPrecio);
    </script>

</body>

</html>