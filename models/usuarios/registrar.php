  <?php

  $conexion = new mysqli("localhost", "root", "", "reservadito");
  if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $control = $_POST["control"];
    $apPaterno = $_POST["apPaterno"];
    $apMaterno = $_POST["apMaterno"];
    $nombre = $_POST["nombre"];
    $sexo = $_POST["sexo"];
    $celular = $_POST["celular"];
    $correo = $_POST["email"];
    $password = $_POST["password"];
    $imagen = $_FILES["imagen"];


    $nombreArchivo = preg_replace("/[^a-zA-Z0-9_-]/", "", strtolower($control));
    $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
    $rutaFinal = "../storage/uploads/usuarios/" . $nombreArchivo . "." . $extension;
    $rutaMover = "../../storage/uploads/usuarios/" . $nombreArchivo . "." . $extension;

    $imagenExitosa = false;
    if ($imagen["size"] > 0) {
      $imagenExitosa = move_uploaded_file($imagen['tmp_name'], $rutaMover);
    } else {
      $rutaFinal = "";
      $imagenExitosa = true;
    }

    if ($imagenExitosa) {
      $stmt = $conexion->prepare("INSERT INTO usuarios (id_usuario, nombre, apPaterno, apMaterno, sexo, contrasena, correoInstitucional, numTelefonico, fotoPerfil, notificacion, tipoUsuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'cliente')");
      $stmt->bind_param("sssssssss", $control, $nombre, $apPaterno, $apMaterno, $sexo, $password, $correo, $celular, $rutaFinal);

      if ($stmt->execute()) {
        echo '<!DOCTYPE html>
        <html>
        <head><title>Registrado</title></head>
        <body data-popup-msg="Usuario registrado exitosamente" data-popup-img="../../assets/media/check.png" data-popup-redi="../../views/login.html">
        <script src="../../assets/js/popup_script.js"></script>
        </body>
        </html>';
      } else {
        echo '<!DOCTYPE html>
        <html>
        <head><title>Error</title></head>
        <body data-popup-msg="Error al registrar usuario" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/registro.php">
        <script src="../../assets/js/popup_script.js"></script>
        </body>
        </html>';
      }

      $stmt->close();
    } else {
      echo '<!DOCTYPE html>
      <html>
      <head><title>Error</title></head>
      <body data-popup-msg="Error al subir la imagen" data-popup-img="../../assets/media/error.png" data-popup-redi="../../views/registro.php">
      <script src="../../assets/js/popup_script.js"></script>
      </body>
      </html>';
    }

    $conexion->close();
  }
  ?>
