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

$id_platillo = $_POST["id"] ?? 0;

if (!is_numeric($id_platillo) || $id_platillo <= 0) {
    die("ID de platillo inválido.");
}

$sql = "SELECT disponibilidad FROM platillos WHERE id_platillo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_platillo);
$stmt->execute();
$result = $stmt->get_result();
$pla = $result->fetch_assoc();

if (!$pla) {
    die("Platillo no encontrado.");
}

$dis = $pla["disponibilidad"];
$stmt->close();

$disponibilidad = ($dis == 1) ? 0 : 1;

$sql = "UPDATE platillos SET disponibilidad = ? WHERE id_platillo = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}
$stmt->bind_param("ii", $disponibilidad, $id_platillo);

if ($stmt->execute()) {
    header("Location: ../../views/admin-platillo.php");
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al cambiar la disponibilidad del platillo" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/admin-platillo.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>
