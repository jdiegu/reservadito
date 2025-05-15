<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos pendientes - Reservadito</title>
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
  include '../includes/conexion.php';
  $sql = "SELECT
    p.id_pedido AS pedido,
    CONCAT(u.nombre, ' ', u.apPaterno, ' ', u.apMaterno) AS nombre_usuario,
    pl.nombrePlatillo AS platillo,
    pl.imagen AS imagen,
    b.nombre_bebida AS bebida,
    a.nombre_acomp AS acomp,
    p.costo_total AS precio,
    p.fecha_pedido AS fecha,
    p.hora_entrega AS hora,
    p.indicaciones AS indi
  FROM pedidos p
  JOIN usuarios u ON p.id_usuario = u.id_usuario
  JOIN platillos pl ON p.id_platillo = pl.id_platillo
  JOIN bebidas b ON p.id_bebida = b.id_bebida
  JOIN acompanamiento a ON p.id_acompanamiento = a.id_acompanamiento
  WHERE p.estado = 0";

  $result = $conn->query($sql);
  ?>

  <main>
    <h1>Pedidos pendientes</h1>
    <section class="menu-list">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<article class="menu-item">';
          echo '<img src="' . htmlspecialchars($row["imagen"]) . '" alt="Platillo">';
          echo '<div class="menu-info">';
          echo '<h2>' . htmlspecialchars($row["platillo"]) . '</h2>';
          echo '<p><strong>Bebida:</strong> ' . htmlspecialchars($row["bebida"]) . '</p>';
          echo '<p><strong>Acompañamiento:</strong> ' . htmlspecialchars($row["acomp"]) . '</p>';
          echo '<p><strong>Indicaciones:</strong> ' . htmlspecialchars($row["indi"]) . '</p>';
          echo '<p><strong>Precio:</strong> $' . number_format($row["precio"], 2) . ' | ';
          echo '<strong>Fecha:</strong> ' . htmlspecialchars($row["fecha"]) . ' | ';
          echo '<strong>Hora:</strong> ' . htmlspecialchars($row["hora"]) . '</p>';
          echo '<strong>Cliente:</strong> ' . htmlspecialchars($row["nombre_usuario"]) . '</p>';
          echo '<button class="btn-completar" value="' . $row["pedido"] . '" > Completar pedido </button>';
          echo '<button class="btn-cancelar" value="' . $row["pedido"] . '" > Cancelar pedido </button>';
          echo '</div>';
          echo '</article>';
        }
      } else {
        echo "<p>No hay platillos disponibles en este momento.</p>";
      }
      $conn->close();
      ?>
    </section>
  </main>

  <div id="confirmModal" class="modal">
    <div class="modal-content">
      <p id="modalMessage">¿Estás seguro que quieres completar este pedido?</p>
      <p id="platilloPedido2"></p>
      <p id="cliendePedidor2"></p>
      <div class="modal-buttons">
        <form action="../models/pedido/completar-pedido.php" method="POST">
          <input id="pedido" type="hidden" name="pedido">
          <button id="confirmBtn" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>

  <div id="cancelModal" class="modal">
    <div class="modal-content">
      <p>¿Estás seguro que quieres cancelar este pedido?</p>
      <p id="platilloPedido2"></p>
      <p id="cliendePedidor2"></p>
      <div class="modal-buttons">
        <form action="../models/pedido/cancelar-pedido.php" method="POST">
          <input id="pedido2" type="hidden" name="pedido">
          <input type="hidden" name="me" value="pedidos-pendientes.php">
          <button id="confirmBtn2" class="btn-confirm">Confirmar</button>
        </form>
        <button id="cancelBtn2" class="btn-cancel">Cancelar</button>
      </div>
    </div>
  </div>

  <?php include '../includes/footer.php' ?>

  <script>
    const modal = document.getElementById('confirmModal');
    const modalCancelar = document.getElementById('cancelModal');

    const btnsComp = document.getElementsByClassName('btn-completar');
    const btnsCancel = document.getElementsByClassName('btn-cancelar');

    const modalPedido = document.getElementById('pedido');
    const modalPedidoCancelar = document.getElementById('pedido2');


    const confirmBtn = document.getElementById('confirmBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    const confirmBtn2 = document.getElementById('confirmBtn2');
    const cancelBtn2 = document.getElementById('cancelBtn2');

    Array.from(btnsComp).forEach(btnComp => {
      btnComp.addEventListener("click", function () {
        modalPedido.value = btnComp.value;
        modal.style.display = "flex";
      });
    });

    Array.from(btnsCancel).forEach(btnCancel => {
      btnCancel.addEventListener("click", function () {
        modalPedidoCancelar.value = btnCancel.value;
        modalCancelar.style.display = "flex";
      });
    });

    cancelBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    cancelBtn2.addEventListener("click", function () {
      modalCancelar.style.display = "none";
    });
  </script>

</body>

</html>