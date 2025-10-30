<?php
session_start();
if ($_SESSION['rol'] != 'admin') header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administrador | Licorería</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow-x: hidden;
    }

    video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.6;
      z-index: -1;
    }

    .content {
      position: relative;
      z-index: 1;
      color: white;
      text-align: center;
      margin-top: 100px;
    }

    .welcome {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      text-shadow: 2px 2px 6px black;
      animation: fadeInUp 2s ease-out;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

  <!-- Video de fondo -->
  <video src="Video/1.mp4" autoplay muted loop></video>

  <!-- Barra de navegación -->
  <nav class="navbar navbar-dark bg-dark px-3">
    <span style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;" class="navbar-brand">Cheers </span>
    <div>
      <a href="productos.php" class="btn btn-outline-light btn-sm">Productos</a>
      <a href="tipos.php" class="btn btn-outline-light btn-sm">Tipos</a>
      <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
    </div>
  </nav>

  <!-- Contenido principal -->
  <div class="container content">
    <h1 class="welcome">Bienvenido, <?php echo $_SESSION['usuario']; ?> </h1>
  </div>

</body>
</html>
