<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modificar Bebida - Reservadito</title>
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

  $id_bebida = $_POST['id'];

  include "../includes/conexion.php";

  $sql = "SELECT * FROM bebidas WHERE id_bebida = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_bebida);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    echo "Bebida no encontrado.";
    exit();
  }
  $bebida = $result->fetch_assoc();

  ?>

  <main>
    <section class="platillo-detalle">

      <form action="../models/bebida/actualizar-bebida.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $bebida["id_bebida"]; ?>">

        <label for="nombre">Nombre de la bebida: </label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $bebida["nombre_bebida"]; ?>" required>

        <label>Precio: $</label>
        <input type="number" name="precio" value="<?php echo $bebida["precio"]; ?>" required>

        <button type="submit" id="agregarBtn">Confirmar</button>

      </form>

      <button class="BtnCancelar" onclick="window.location.href='admin-bebida.php'">Cancelar</button>

    </section>
  </main>


  <?php include '../includes/footer.php' ?>

</body>

</html>