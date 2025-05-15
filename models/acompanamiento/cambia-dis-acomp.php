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

$id_acomp = $_POST["id"] ?? 0;

$sql = "SELECT disponibilidad FROM acompanamiento WHERE id_acompanamiento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_acomp);
$stmt->execute();
$result = $stmt->get_result();
$pla = $result->fetch_assoc();


$dis = $pla["disponibilidad"];
$stmt->close();

$disponibilidad = ($dis == 1) ? 0 : 1;

$sql = "UPDATE acompanamiento SET disponibilidad = ? WHERE id_acompanamiento = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en el cambio de disponibilidad: " . $conn->error);
}
$stmt->bind_param("ii", $disponibilidad, $id_acomp);

if ($stmt->execute()) {
  header("Location: ../../views/admin-acomp.php");
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al cambiar la disponibilidad del acompañamiento" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/admin-acomp.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';

}

$stmt->close();
$conn->close();
?>
