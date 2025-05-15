<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acompañamientos - Reservadito</title>
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

  $sql = "SELECT id_acompanamiento, nombre_acomp, precio, disponibilidad FROM acompanamiento WHERE id_acompanamiento <> 0";
  $result = $conn->query($sql);
  ?>

  <main>
    <h1>Administrar Acompañamientos</h1>
    <button class="btn-agregar" onclick="window.location.href='agregar-acomp.php'">Agregar nuevo acompañamiento</button>

    <section class="menu-list">
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<article class="menu-item">';
          echo '<div class="menu-info">';
          echo '<h2>' . htmlspecialchars($row["nombre_acomp"]) . '</h2>';
          echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . '</p>';
          echo '<p><strong>Disponibilidad:</strong> ' . ($row["disponibilidad"] == 1 ? 'Sí' : 'No') . '</p>';
          echo '</div>';
          echo '<ul class="list-btns">';
          echo '<li>';
          echo '<form action="editar-acomp.php" method="POST">';
          echo '<input type="hidden" name="id" value="' . $row["id_acompanamiento"] . '">';
          echo '<button type="submit" class="btn-ordenar">Modificar</button>';
          echo '</form>';
          echo '</li>';
          echo '<li>';
          echo '<button class="btn-eliminar" value="' . $row["id_acompanamiento"] . '">Eliminar</button>';
          echo '</li>';
          echo '<li>';
          echo '<button class="btn-disp" value="' . $row["id_acompanamiento"] . '">Cambiar disponibilidad</button>';
          echo '</li>';
          echo '</ul>';

          echo '</article>';
        }
      } else {
        echo "<p>No hay Acompañamientos disponibles en este momento.</p>";
      }
      $conn->close();
      ?>
    </section>
  </main>

  <div id="confirmaEliminar" class="modal">
    <div class="modal-content">
      <p id="modalMessage">¿Estás seguro que quieres eliminar este acompañamiento?</p>
      <div class="modal-buttons">
        <form action="../models/acompanamiento/eliminar-acomp.php" method="POST">
          <input id="acomp" type="hidden" name="acomp">
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
        <form action="../models/acompanamiento/cambia-dis-acomp.php" method="POST">
          <input id="acomp2" type="hidden" name="id">
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
    const inputAcomp = document.getElementById('acomp');
    const cancelBtn = document.getElementById('cancelBtn');

    Array.from(btnsEliminar).forEach(btn => {
      btn.addEventListener("click", function () {
        inputAcomp.value = btn.value;
        modal.style.display = "flex";
      });
    });

    cancelBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    const modal2 = document.getElementById('confirmaCambiaDis');
    const btnsDisp = document.getElementsByClassName('btn-disp');
    const inputAcomp2 = document.getElementById('acomp2');
    const cancelBtn2 = document.getElementById('cancelBtn2');

    Array.from(btnsDisp).forEach(btn => {
      btn.addEventListener("click", function () {
        inputAcomp2.value = btn.value;
        modal2.style.display = "flex";
      });
    });

    cancelBtn2.addEventListener("click", function () {
      modal2.style.display = "none";
    });
  </script>
</body>

</html>