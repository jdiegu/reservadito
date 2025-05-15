<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: HTML/login.html");
    exit();
}

if ($_SESSION["tipo"] != 'admin'){
    echo "<script>alert('No eres usuario administrador'); window.location.href='../../index.php';</script>";
}

$conn = new mysqli("localhost", "root", "", "reservadito");
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$id_bebida = $_POST["id"] ?? 0;
$nombre = $_POST["nombre"] ?? "";
$precio = $_POST["precio"] ?? 0;

// Insertar el pedido
$sql = "UPDATE bebidas SET nombre_bebida = ? , precio = ? WHERE id_bebida = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}

$stmt->bind_param("sii", $nombre, $precio, $id_bebida);

if ($stmt->execute()) {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Actualizado</title>
   </head>
   <body data-popup-msg="La Bebida se actualizo exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al actualizar la bebida" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>
