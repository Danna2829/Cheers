<?php
session_start();
include("conexion.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = mysqli_prepare($conn, "SELECT id_usuario, nombre, rol, password FROM usuarios WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && mysqli_num_rows($resultado) === 1) {
            $usuario = mysqli_fetch_assoc($resultado);

            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario']    = $usuario['nombre'];
                $_SESSION['rol']        = $usuario['rol'];
                $_SESSION['id_usuario'] = $usuario['id_usuario'];

                $destino = ($usuario['rol'] === 'admin') ? "dashboard_admin.php" : "dashboard_cliente.php";
                header("Location: $destino");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Correo no registrado.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login | Licorería</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

    body {
      background: radial-gradient(circle,rgba(190, 198, 235, 1) 0%, rgba(126, 30, 235, 1) 47%, rgba(247, 84, 117, 1) 100%);
    }
   
    .login-card {
        width: 22rem;
 
    }
    .logo-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-top: -60px;
        background: #ffffffff;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>


<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow text-center login-card position-relative">
    <div class="d-flex justify-content-center">
      <img src="img/Cheers.png" class="logo-img" alt="Logo Licorería">
    </div>
    <h4 class="mt-3 mb-3">Licorería</h4>

        

    <form method="POST">
      
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Correo" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
      </div>
      <button class="btn btn-primary w-100">Entrar</button>
      
      <?php if(isset($error)): ?>
        <p class="text-danger text-center mt-2"><?= $error ?></p>
      <?php endif; ?>
    </form>
  </div>
</div>
</body>
</html>


