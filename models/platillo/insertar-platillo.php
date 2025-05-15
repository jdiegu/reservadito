<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../HTML/login.html");
  exit();
}

if ($_SESSION["tipo"] != 'admin') {
  echo "<script>alert('No eres usuario administrador'); window.location.href='../../index.php';</script>";
}

$conexion = new mysqli("localhost", "root", "", "reservadito");
if ($conexion->connect_error) {
  die("Error en la conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  $precio = $_POST["precio"] ?? 0;
  $tiempo = $_POST["tiempo_preparacion"] ?? 0;
  $imagen = $_FILES["imagen"];

  // Crear nombre del archivo basado en el nombre del platillo
  $nombreLimpio = preg_replace("/[^a-zA-Z0-9_-]/", "", strtolower($nombre));
  $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
  $rutaFinal = "../storage/uploads/platillos/" . $nombreLimpio . "." . $extension;
  $rutaMover = "../../storage/uploads/platillos/" . $nombreLimpio . "." . $extension;
  $disponibilidad = 1;

  if (move_uploaded_file($imagen['tmp_name'], $rutaMover)) {
    $stmt = $conexion->prepare("INSERT INTO platillos (nombrePlatillo, disponibilidad, precio, tiempoPreparacion, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $disponibilidad, $precio, $tiempo, $rutaFinal);

    if ($stmt->execute()) {
      echo '<!DOCTYPE html>
      <html>
      <head>
       <title>Agregado</title>
      </head>
      <body data-popup-msg="Platillo agregado exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/admin-platillo.php">
      <script src="../../assets/js/popup_script.js"></script>
      </body>
      </html>';

    } else {
      echo '<!DOCTYPE html>
      <html>
      <head>
       <title>Error</title>
      </head>
      <body data-popup-msg="Error al agregar el platillo" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/agregar-platillo.php">
      <script src="../../assets/js/popup_script.js"></script>
      </body>
      </html>';
    }

    $stmt->close();
  } else {
    echo '<!DOCTYPE html>
      <html>
      <head>
       <title>Error</title>
      </head>
      <body data-popup-msg="Error al subir la imagen" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/agregar-platillo.php">
      <script src="../../assets/js/popup_script.js"></script>
      </body>
      </html>';
  }

  $conexion->close();
}
?>