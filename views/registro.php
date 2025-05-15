<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro - Reservadito</title>
  <link rel="stylesheet" href="../assets/css/estilo-general.css" />
</head>

<body>
  <header>
    <div class="logo">
      <img src="../assets/media/logo.png" alt="Reservadito" />
    </div>
  </header>

  <main>
    <h1>Por favor registra tus datos</h1>

    <form action="../models/usuarios/registrar.php" method="post" enctype="multipart/form-data">
      <!-- Número de control -->
      <label for="control">Número de control</label>
      <input type="text" id="control" name="control" maxlength="20" required />

      <!-- Apellido paterno -->
      <label for="apPaterno">Apellido Paterno</label>
      <input type="text" id="apPaterno" name="apPaterno" maxlength="15" required />

      <!-- Apellido materno -->
      <label for="apMaterno">Apellido Materno</label>
      <input type="text" id="apMaterno" name="apMaterno" maxlength="15" required />

      <!-- Nombre -->
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" maxlength="15" required />

      <!-- Sexo -->
      <label for="sexo">Sexo</label>
      <select id="sexo" name="sexo" required>
        <option value="">Selecciona una opción</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
        <option value="O">Otro</option>
      </select>

      <!-- Número telefónico -->
      <label for="celular">Número celular</label>
      <input type="tel" id="celular" name="celular" pattern="[0-9]{10}" maxlength="10" required />

      <!-- Correo institucional -->
      <label for="email">Correo institucional</label>
      <input type="email" id="email" name="email" maxlength="50" required />

      <!-- Contraseña -->
      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" maxlength="16" required />

      <!-- Confirmación de contraseña -->
      <label for="confirm-password">Confirmar contraseña</label>
      <input type="password" id="confirm-password" name="confirm-password" maxlength="16" required />

      <!-- Foto de perfil -->
      <label for="imagen">Foto de perfil (opcional)</label>
      <input type="file" name="imagen" id="imagen" accept="image/*" />
      <img id="vista-previa" src="#" alt="Vista previa" style="display:none; max-width: 200px;" />

      <!-- Botón -->
      <button type="submit">Registrarse</button>
    </form>
  </main>

  <?php include '../includes/footer.php' ?>

  <script>
    const inputImagen = document.getElementById("imagen");
    const vistaPrevia = document.getElementById("vista-previa");

    inputImagen.addEventListener("change", function () {
      const archivo = this.files[0];
      if (archivo) {
        const lector = new FileReader();
        lector.onload = function (e) {
          vistaPrevia.src = e.target.result;
          vistaPrevia.style.display = "block";
        };
        lector.readAsDataURL(archivo);
      } else {
        vistaPrevia.src = "#";
        vistaPrevia.style.display = "none";
      }
    });
  </script>
</body>
</html>
