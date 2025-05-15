<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Reservadito");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nControl = $_POST["id"];
    $password = $_POST["password"];

    $sql = "SELECT id_usuario, nombre, tipoUsuario FROM usuarios WHERE id_usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nControl, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION["user_id"] = $user["id_usuario"];
        $_SESSION["nombre"] = $user["nombre"];
        $_SESSION["tipo"] = $user["tipoUsuario"];
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Credenciales incorrectas'); window.location.href='../views/login.html';</script>";
    }
    $stmt->close();
}
$conn->close();
?>