<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Platillo - Reservadito</title>
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

      <h1>Crear platillo</h1>
      <p>Agregue la informacion que se solicita</p>

      <form action="../models/platillo/insertar-platillo.php" method="POST" enctype="multipart/form-data">

        <label for="nombre">Nombre del platillo: </label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>

        <label>Precio: $</label>
        <input type="number" name="precio" step="0.01" required>

        <label>Tiempo de preparación (min): </label>
        <input type="number" name="tiempo_preparacion" required>

        <label>Imagen del platillo:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>
        <br><br>
        <img id="vista-previa" src="#" alt="Vista previa" style="display:none; max-width: 200px;" />

        <button type="submit" id="agregarBtn">Agregar platillo</button>
      </form>


      <button class="BtnCancelar" onclick="window.location.href='admin-platillo.php'">Cancelar</button>

    </section>
  </main>

  <?php include '../includes/footer.php' ?>

  <script>
    const inputImagen = document.getElementById("imagen");
    const vistaPrevia = document.getElementById("vista-previa");

    inputImagen.addEventListener("change", function () {
      const archivo = this.files[0];
      if (archivo) {
        const lector = new FileReader();
        lector.onload = function (e) {
          vistaPrevia.src = e.target.result;
          vistaPrevia.style.display = "block";
        };
        lector.readAsDataURL(archivo);
      } else {
        vistaPrevia.src = "#";
        vistaPrevia.style.display = "none";
      }
    });
  </script>

</body>

</html>