<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "Reservadito";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT notificacion FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $tipo = (int)$row['notificacion'];

    if ($tipo === 1) {
        $mensaje = "¡Tu pedido está listo! Pasa por él a la cafetería.";
    } elseif ($tipo === 2) {
        $mensaje = "¡Tu pedido ha sido entregado! Gracias por usar Reservadito.";
    } elseif ($tipo === 3) {
        $mensaje = "¡Tu pedido ha sido cancelado! Hubo un error con tu pedido, disculpas.";
    } elseif ($tipo === 4) {
        $mensaje = "¡Hay pedidos pendientes! Revisalos en el apartado PEDIDOS.";
    } else {
        $mensaje = null;
    }


    if ($mensaje !== null) {
        $update = $conn->prepare("UPDATE usuarios SET notificacion = 0 WHERE id_usuario = ?");
        $update->bind_param("i", $user_id);
        $update->execute();

        echo json_encode(["mensaje" => $mensaje]);
    } else {
        echo json_encode(["mensaje" => null]);
    }
} else {
    echo json_encode(["mensaje" => null]);
}
?>
