<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: HTML/login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "reservadito");
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$id_usuario =$_SESSION["user_id"];
$id_pedido = $_POST["pedido"];
$calificacion = $_POST["calificacion"] ?? 0;
$comentario = $_POST["resena"] ?? '';

$sql = "INSERT INTO resena (id_pedido, calificacion, comentario, id_usuario)
        VALUES (?, ?, ?,?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}

$stmt->bind_param("iisi", $id_pedido, $calificacion, $comentario, $id_usuario);

if ($stmt->execute()) {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Reseña agregada</title>
   </head>
   <body data-popup-msg="Reseña agregada exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/compras.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al agregar la reseña" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/resena.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>
