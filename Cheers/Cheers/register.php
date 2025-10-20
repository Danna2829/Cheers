<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO usuarios (nombre, email, password, rol)
            VALUES ('$nombre', '$email', '$password', 'cliente')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        $error = "Error al registrar usuario: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro | Licorería</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="width: 25rem;">
    <h4 class="text-center mb-3">Crear cuenta cliente 🍾</h4>
    <form method="POST">
      <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
      <input class="form-control mb-2" type="email" name="email" placeholder="Correo" required>
      <input class="form-control mb-3" type="password" name="password" placeholder="Contraseña" required>
      <button class="btn btn-success w-100">Registrar</button>
      <div class="text-center mt-3">
        <a href="index.php">Volver al login</a>
      </div>
      <?php if(isset($error)) echo "<p class='text-danger text-center mt-2'>$error</p>"; ?>
    </form>
  </div>
</div>
</body>
</html>
