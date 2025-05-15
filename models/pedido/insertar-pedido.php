<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: HTML/login.html");
    exit();
}

if (!isset($_POST['id_platillo'])) {
    echo "Datos incompletos.";
    exit();
}

$id_usuario = $_SESSION["user_id"];

$id_platillo = $_POST['id_platillo'];
$id_bebida = $_POST['bebida'] ?? 0;
$id_acompanamiento = $_POST['acompanamiento'] ?? 0;
$indicaciones = $_POST['indicaciones'] ?? '';


// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "reservadito");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener precio del platillo y tiempo de preparación
$sql = "SELECT precio, tiempoPreparacion FROM platillos WHERE id_platillo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_platillo);
$stmt->execute();
$result = $stmt->get_result();
$platillo = $result->fetch_assoc();
$precio_platillo = $platillo['precio'];
$tiempo_preparacion = $platillo['tiempoPreparacion'];

// Obtener precio de la bebida
$precio_bebida = 0;
if ($id_bebida != 0) {
    $sql = "SELECT precio FROM bebidas WHERE id_bebida = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bebida);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $precio_bebida = $row['precio'];
    }
}

// Obtener precio del acompañamiento
$precio_acomp = 0;
if ($id_acompanamiento != 0) {
    $sql = "SELECT precio FROM acompanamiento WHERE id_acompanamiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_acompanamiento);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $precio_acomp = $row['precio'];
    }
}

// Calcular costo total
$costo_total = $precio_platillo + $precio_bebida + $precio_acomp;

// Insertar el pedido
$sql = "INSERT INTO pedidos
        (id_usuario, id_platillo, id_bebida, id_acompanamiento, costo_total, fecha_pedido, indicaciones, hora_entrega, estado)
        VALUES (?, ?, ?, ?, ?, CURDATE(), ?, ADDTIME(CURTIME(), SEC_TO_TIME(? * 60)), 0)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación del pedido: " . $conn->error);
}

$stmt->bind_param("iiiiisi", $id_usuario, $id_platillo, $id_bebida, $id_acompanamiento, $costo_total, $indicaciones, $tiempo_preparacion);

if ($stmt->execute()) {
    // Actualizar notificación para usuarios administradores
    $update_sql = "UPDATE usuarios SET notificacion = 4 WHERE tipoUsuario = 'admin'";
    $conn->query($update_sql);

    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Pedido completado</title>
   </head>
   <body data-popup-msg="Pedido registrado exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/menu.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
} else {
    echo '<!DOCTYPE html>
   <html>
   <head>
       <title>Error</title>
   </head>
   <body data-popup-msg="Error al registrar el pedido" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/platillo.php">
   <script src="../../assets/js/popup_script.js"></script>
   </body>
   </html>';
}

$stmt->close();
$conn->close();
?>