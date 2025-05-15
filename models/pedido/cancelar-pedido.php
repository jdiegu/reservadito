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


$id_usuario = $_SESSION["user_id"];
$id_pedido = $_POST["pedido"];

$redi = $_POST["me"];

$sql = "UPDATE pedidos SET estado = 3 WHERE id_pedido = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}

$stmt->bind_param("i", $id_pedido);

if ($stmt->execute()) {

    $sql_usuario = "SELECT id_usuario FROM pedidos WHERE id_pedido = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $id_pedido);
    $stmt_usuario->execute();
    $result = $stmt_usuario->get_result();
    if ($row = $result->fetch_assoc()) {
        $id_cliente = $row['id_usuario'];

        // Actualizar la notificación a 2 para ese usuario
        $update_sql = "UPDATE usuarios SET notificacion = 3 WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("i", $id_cliente);
        $stmt_update->execute();
        $stmt_update->close();
    }
    $stmt_usuario->close();

    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Cancelado</title>
    </head>
    <body data-popup-msg="Pedido cancelado exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/'. $redi. '">
    <script src="../../assets/js/popup_script.js"></script>
    </body>
    </html>';
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
    </head>
    <body data-popup-msg="Error al cancelar el pedido" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/'. $redi. '">
    <script src="../../assets/js/popup_script.js"></script>
    </body>
    </html>';
}

$stmt->close();
$conn->close();
?>