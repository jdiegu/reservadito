<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bebidas - Reservadito</title>
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
  $sql = "SELECT id_bebida, nombre_bebida, precio, disponibilidad FROM bebidas WHERE id_bebida <> 0";
  $result = $conn->query($sql);
  ?>

  <main>
    <h1>Administrar Bebidas</h1>
    <button class="btn-agregar" onclick="window.location.href='agregar-bebida.php'">Agregar nueva bebida</button>

    <section class="menu-list">
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<article class="menu-item">';
          echo '<div class="menu-info">';
          echo '<h2>' . htmlspecialchars($row["nombre_bebida"]) . '</h2>';
          echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . '</p>';
          echo '<p><strong>Disponibilidad:</strong> ' . ($row["disponibilidad"] == 1 ? 'Sí' : 'No') . '</p>';

          echo '</div>';
          echo '<ul class="list-btns">';
          echo '<li>';
          echo '<form action="editar-bebida.php" method="POST">';
          echo '<input type="hidden" name="id" value="' . $row["id_bebida"] . '">';
          echo '<button type="submit" class="btn-ordenar">Modificar</button>';
          echo '</form>';
          echo '</li>';
          echo '<li>';
          echo '<button class="btn-eliminar" value="' . $row["id_bebida"] . '">Eliminar</button>';
          echo '</li>';
          echo '<li>';
          echo '<button class="btn-disp" value="' . $row["id_bebida"] . '">Cambiar disponibilidad</button>';
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
  <div id="confirmaEliminar" class="modal">
    <div class="modal-content">
      <p id="modalMessage">¿Estás seguro que quieres eliminar esta bebida?</p>
      <div class="modal-buttons">
        <form action="../models/bebida/eliminar-bebida.php" method="POST">
          <input id="bebida" type="hidden" name="bebida">
          <button id="confirmBtn" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>
  <div id="confirmaCambiaDis" class="modal">
    <div class="modal-content">
      <p id="modalMessage2">¿Estás seguro que quieres cambiar la disponibilidad?</p>
      <div class="modal-buttons">
        <form action="../models/bebida/cambia-dis-bebida.php" method="POST">
          <input id="bebida2" type="hidden" name="id">
          <button id="confirmBtn2" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn2" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>

  <?php include '../includes/footer.php' ?>

  <script>
    const modal = document.getElementById('confirmaEliminar');
    const btnsEliminar = document.getElementsByClassName('btn-eliminar');
    const inputBebida = document.getElementById('bebida');
    const cancelBtn = document.getElementById('cancelBtn');

    Array.from(btnsEliminar).forEach(btn => {
      btn.addEventListener("click", function () {
        inputBebida.value = btn.value;
        modal.style.display = "flex";
      });
    });

    cancelBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    const modal2 = document.getElementById('confirmaCambiaDis');
    const btnsDisp = document.getElementsByClassName('btn-disp');
    const inputBebida2 = document.getElementById('bebida2');
    const cancelBtn2 = document.getElementById('cancelBtn2');

    Array.from(btnsDisp).forEach(btn => {
      btn.addEventListener("click", function () {
        inputBebida2.value = btn.value;
        modal2.style.display = "flex";
      });
    });

    cancelBtn2.addEventListener("click", function () {
      modal2.style.display = "none";
    });
  </script>
</body>

</html>