<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modificar Platillo - Reservadito</title>
  <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>

  <?php
  include "../includes/header.php";

  if ($_SESSION["tipo"] != 'admin') {
    echo "<script>alert('No eres usuario administrador'); window.location.href='../index.php';</script>";
  }
  ?>

  <?php
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
  ?>

  <main>
    <section class="platillo-detalle">
      <img src="<?php echo htmlspecialchars($platillo['imagen']); ?>" alt="Imagen del platillo" class="imagen-platillo">

      <form action="../models/platillo/actualizar-platillo.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $platillo["id_platillo"]; ?>">

        <label for="nombre">Nombre del platillo: </label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $platillo["nombrePlatillo"]; ?>" required>

        <label>Precio: $</label>
        <input type="number" name="precio" value="<?php echo $platillo["precio"]; ?>" required>

        <label>Tiempo de preparación (min): </label>
        <input type="number" name="tiempo_preparacion" value="<?php echo $platillo["tiempoPreparacion"]; ?>" required>

        <button type="submit" id="agregarBtn">Confirmar</button>

      </form>

      <button class="BtnCancelar" onclick="window.location.href='admin-platillo.php'">Cancelar</button>

    </section>
  </main>


  <?php include '../includes/footer.php' ?>

</body>

</html>