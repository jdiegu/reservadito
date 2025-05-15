  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar acompañamiento - Reservadito</title>
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
    $id_acomp = $_POST['id'];
    include "../includes/conexion.php";
    $sql = "SELECT * FROM acompanamiento WHERE id_acompanamiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_acomp);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
      echo "Acompañamiento no encontrado.";
      exit();
    }
    $acomp = $result->fetch_assoc();

    ?>

    <main>
      <section class="platillo-detalle">

        <form action="../models/acompanamiento/actualizar-acomp.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $acomp["id_acompanamiento"]; ?>">

          <label for="nombre">Nombre del acompañamiento: </label>
          <input type="text" name="nombre" id="nombre" value="<?php echo $acomp["nombre_acomp"]; ?>" required>

          <label>Precio: $</label>
          <input type="number" name="precio" value="<?php echo $acomp["precio"]; ?>" required>

          <button type="submit" id="agregarBtn">Confirmar</button>

        </form>

        <button class="BtnCancelar" onclick="window.location.href='admin-acomp.php'">Cancelar</button>

      </section>
    </main>

    <?php include '../includes/footer.php' ?>

  </body>

  </html>