<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Platillos - Reservadito</title>
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
  include "../includes/conexion.php";
  $sql = "SELECT id_platillo, nombrePlatillo, precio, tiempoPreparacion, imagen, disponibilidad FROM platillos";
  $result = $conn->query($sql);
  ?>


  <main>
    <h1>Administrar Platillos</h1>
    <button class="btn-agregar" onclick="window.location.href='agregar-platillo.php'">Agregar nuevo platillo</button>

    <section class="menu-list">
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<article class="menu-item">';
          echo '<img src="' . htmlspecialchars($row["imagen"]) . '" alt="Platillo">';
          echo '<div class="menu-info">';
          echo '<h2>' . htmlspecialchars($row["nombrePlatillo"]) . '</h2>';
          echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . '</p>';
          echo '<p><strong>Tiempo estimado de preparación:</strong> ' . htmlspecialchars($row["tiempoPreparacion"]) . ' min</p>';
          echo '<p><strong>Disponibilidad:</strong> ' . ($row["disponibilidad"] == 1 ? 'Sí' : 'No') . '</p>';

          echo '</div>';

          echo '<ul class="list-btns">';
          // Modificar
          echo '<li>';
          echo '<form action="editar-platillo.php" method="POST">';
          echo '<input type="hidden" name="id" value="' . $row["id_platillo"] . '">';
          echo '<button type="submit" class="btn-ordenar">Modificar</button>';
          echo '</form>';
          echo '</li>';
          // Eliminar
          echo '<li>';
          echo '<button class="btn-eliminar" value="' . $row["id_platillo"] . '">Eliminar</button>';
          echo '</li>';
          // Cambiar disponibilidad
          echo '<li>';
          echo '<button class="btn-disp" value="' . $row["id_platillo"] . '">Cambiar disponibilidad</button>';
          echo '</li>';
          echo '</ul>';
          echo '</article>';
        }
      } else {
        echo "<p>No hay platillos disponibles en este momento.</p>";
      }
      $conn->close();
      ?>
    </section>
  </main>

  <!-- Modal de Confirmación Eliminar -->
  <div id="confirmaEliminar" class="modal">
    <div class="modal-content">
      <p id="modalMessage">¿Estás seguro que quieres eliminar este platillo?</p>
      <div class="modal-buttons">
        <form action="../models/platillo/eliminar-platillo.php" method="POST">
          <input id="platillo" type="hidden" name="platillo">
          <button id="confirmBtn" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>

  <!-- Modal de Cambiar Disponibilidad -->
  <div id="confirmaCambiaDis" class="modal">
    <div class="modal-content">
      <p id="modalMessage2">¿Estás seguro que quieres cambiar la disponibilidad?</p>
      <div class="modal-buttons">
        <form action="../models/platillo/cambia-dis-platillo.php" method="POST">
          <input id="platillo2" type="hidden" name="id">
          <button id="confirmBtn2" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn2" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>


  <?php include '../includes/footer.php' ?>

  <script>
    // Modal para eliminar
    const modal = document.getElementById('confirmaEliminar');
    const btnsEliminar = document.getElementsByClassName('btn-eliminar');
    const inputPlatillo = document.getElementById('platillo');
    const cancelBtn = document.getElementById('cancelBtn');

    Array.from(btnsEliminar).forEach(btn => {
      btn.addEventListener("click", function () {
        inputPlatillo.value = btn.value;
        modal.style.display = "flex";
      });
    });

    cancelBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    // Modal para cambiar disponibilidad
    const modal2 = document.getElementById('confirmaCambiaDis');
    const btnsDisp = document.getElementsByClassName('btn-disp');
    const inputPlatillo2 = document.getElementById('platillo2');
    const cancelBtn2 = document.getElementById('cancelBtn2');

    Array.from(btnsDisp).forEach(btn => {
      btn.addEventListener("click", function () {
        inputPlatillo2.value = btn.value;
        modal2.style.display = "flex";
      });
    });

    cancelBtn2.addEventListener("click", function () {
      modal2.style.display = "none";
    });
  </script>
</body>

</html>