<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agrega Acompañamiento - Reservadito</title>
  <link rel="stylesheet" href="../assets/css/estilo-general.css">
</head>

<body>

  <?php
  include "../includes/header.php";

  if ($_SESSION["tipo"] != 'admin') {
    echo "<script>alert('No eres usuario administrador'); window.location.href='../index.php';</script>";
  }
  ?>

  <main>
    <section class="platillo-detalle">

      <h1>Crear Acompañamiento</h1>
      <p>Agregue la informacion que se solicita</p>

      <form action="../models/acompanamiento/insertar-acomp.php" method="POST">

        <label for="nombre">Nombre del acompañamiento: </label>
        <input type="text" name="nombre" id="nombre" required>

        <label>Precio: $</label>
        <input type="number" name="precio" required>

        <button type="submit" id="agregarBtn">Agregar acompañamiento</button>
      </form>


      <button class="BtnCancelar" onclick="window.location.href='admin-acomp.php'">Cancelar</button>

    </section>
  </main>

  <?php include '../includes/footer.php' ?>

</body>

</html>