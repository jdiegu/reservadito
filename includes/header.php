<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION["user_id"];
$tipoUsuario = $_SESSION["tipo"];
?>
<header class="header-container">
  <div class="logo">
    <img src="../assets/media/logo.png" alt="Logo">
  </div>
  <nav class="main-nav">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <?php if ($tipoUsuario === 'cliente'): ?>
        <li><a href="menu.php">Menú</a></li>
        <li><a href="compras.php">Compras</a></li>
      <?php endif; ?>
      <?php if ($tipoUsuario === 'admin'): ?>
        <li class="dropdown">
          <a href="#">Pedidos ▾</a>
          <ul class="dropdown-content">
            <li><a href="pedidos-pendientes.php">Pedidos pendientes</a></li>
            <li><a href="pedidos-por-entregar.php">Pedidos por entregar</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#">Administrar ▾</a>
          <ul class="dropdown-content">
            <li><a href="admin-platillo.php">Platillos</a></li>
            <li><a href="admin-bebida.php">Bebidas</a></li>
            <li><a href="admin-acomp.php">Acompañamientos</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <li> <a href="perfil.php">Perfil</a></li>
    </ul>
  </nav>
</header>
