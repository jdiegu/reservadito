<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../HTML/login.html");
  exit();
}

if ($_SESSION["tipo"] != 'admin'){
  echo "<script>alert('No eres usuario administrador'); window.location.href='../../index.php';</script>";
}

$conn = new mysqli("localhost", "root", "", "reservadito");
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$disp = 1;

$sql = "INSERT INTO bebidas (nombre_bebida , precio, disponibilidad) VALUES ( ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparacion de la bebida: " . $conn->error);
}

$stmt->bind_param("sii", $nombre, $precio, $disp);

if ($stmt->execute()) {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Agragado</title>
   </head>
   <body data-popup-msg="Se agrego la bebida exitosamente exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';

} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al agregar la bebida" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/agregar-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}


?>
