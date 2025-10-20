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
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
  <span style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;" class="navbar-brand"> Cheers 🍷</span>
  <div>
    <a href="productos.php" class="btn btn-outline-light btn-sm">Productos</a>
    <a href="tipos.php" class="btn btn-outline-light btn-sm">Tipos</a>
    <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
  </div>
</nav>

<div class="container mt-5">
  <h3>Bienvenido, <?php echo $_SESSION['usuario']; ?> </h3>
</div>
</body>
</html>
