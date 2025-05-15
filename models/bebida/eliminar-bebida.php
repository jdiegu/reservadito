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

$id = $_POST["bebida"] ?? 0;

// Insertar el pedido
$sql = "DELETE FROM bebidas WHERE id_bebida = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Eliminado</title>
   </head>
   <body data-popup-msg="La Bebida se elimino exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';

} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al eliminar la bebida" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>
