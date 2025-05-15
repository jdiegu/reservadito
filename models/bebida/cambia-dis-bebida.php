<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: HTML/login.html");
    exit();
}

if ($_SESSION["tipo"] != 'admin'){
    echo "<script>alert('No eres usuario administrador'); window.location.href='../index.php';</script>";
}

$conn = new mysqli("localhost", "root", "", "reservadito");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_bebida = $_POST["id"] ?? 0;

$sql = "SELECT disponibilidad FROM bebidas WHERE id_bebida = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_bebida);
$stmt->execute();
$result = $stmt->get_result();
$pla = $result->fetch_assoc();

if (!$pla) {
    die("Bebida no encontrada.");
}

$dis = $pla["disponibilidad"];
$stmt->close();

$disponibilidad = ($dis == 1) ? 0 : 1;

$sql = "UPDATE bebidas SET disponibilidad = ? WHERE id_bebida = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del cambio: " . $conn->error);
}
$stmt->bind_param("ii", $disponibilidad, $id_bebida);

if ($stmt->execute()) {
  header("Location: ../../views/admin-bebida.php");
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al cambiar la disponibilidad de la bebida" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/admin-bebida.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>
