<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Añadir reseña - Reservadito</title>
  <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>

  <?php include "../includes/header.php" ?>

  <?php

  if (!isset($_POST['pedido'])) {
    echo "No se recibió ningún pedido.";
    exit();
  }

  $id_pedido = $_POST['pedido'];

  include '../includes/conexion.php';

  $sql = "SELECT
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
  WHERE p.id_pedido = ? ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_pedido);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    echo "Platillo no encontrado.";
    exit();
  }
  $pedido = $result->fetch_assoc();
  ?>

  <main>
    <section class="platillo-detalle">

      <img src="<?php echo htmlspecialchars($pedido['imagen']); ?>" alt="Imagen del platillo" class="imagen-platillo">

      <h1><?php echo htmlspecialchars($pedido['platillo']); ?></h1>
      <p class="precio">MX$ <?php echo number_format($pedido['precio'], 2); ?></p>

      <?php
      echo '<p><strong>Bebida:</strong> ' . htmlspecialchars($pedido["bebida"]) . '</p>';
      echo '<p><strong>Acompañamiento:</strong> ' . htmlspecialchars($pedido["acompanamiento"]) . '</p>';
      echo '<p><strong>Indicaciones:</strong> ' . htmlspecialchars($pedido["indi"]) . '</p>';

      echo '<p><strong>Precio:</strong> $' . number_format($pedido["precio"], 2) . ' | ';
      echo '<strong>Fecha:</strong> ' . htmlspecialchars($pedido["fecha"]) . ' | ';
      echo '<strong>Hora:</strong> ' . htmlspecialchars($pedido["hora"]) . '</p>';
      ?>

      <hr>

      <form action="../models/resena/insertar-resena.php" method="POST">

        <input type="hidden" name="pedido" value="<?php echo $id_pedido; ?>">

        <label>Calificación:</label>
        <div class="estrellas">
          <input type="radio" id="estrella1" name="calificacion" value="1"><label for="estrella1">★</label>
          <input type="radio" id="estrella2" name="calificacion" value="2"><label for="estrella2">★</label>
          <input type="radio" id="estrella3" name="calificacion" value="3"><label for="estrella3">★</label>
          <input type="radio" id="estrella4" name="calificacion" value="4"><label for="estrella4">★</label>
          <input type="radio" id="estrella5" name="calificacion" value="5"><label for="estrella5">★</label>
        </div>

        <label for="resena">Reseña:</label>
        <textarea id="resena" name="resena" rows="5" maxlength="150"
          placeholder="Escribe aqui tu comentario..."></textarea>

        <button type="submit" id="agregarBtn">Agregar reseña</button>
      </form>

      <button onclick="window.location.href='compras.php'">Cancelar</button>

    </section>
  </main>

  <?php include '../includes/footer.php' ?>

</body>

</html>