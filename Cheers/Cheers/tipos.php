<?php
session_start();
if ($_SESSION['rol'] != 'admin') header("Location: index.php");
include("conexion.php");

// Crear tipo
if (isset($_POST['add'])) {
    $nombre_tipo = $_POST['nombre_tipo'];
    mysqli_query($conn, "INSERT INTO tipos_productos (nombre_tipo) VALUES ('$nombre_tipo')");
    header("Location: tipos.php");
}

// Actualizar tipo
if (isset($_POST['update'])) {
    $id = $_POST['id_tipo'];
    $nombre_tipo = $_POST['nombre_tipo'];
    mysqli_query($conn, "UPDATE tipos_productos SET nombre_tipo='$nombre_tipo' WHERE id_tipo=$id");
    header("Location: tipos.php");
}

// Eliminar tipo
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tipos_productos WHERE id_tipo=$id");
    header("Location: tipos.php");
}

$tipos = mysqli_query($conn, "SELECT * FROM tipos_productos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tipos de Productos | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">🍾 Tipos de Productos</span>
  <div>
    <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm">Volver</a>
    <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Lista de tipos de productos</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Nuevo Tipo</button>
  </div>

  <table class="table table-hover table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre del tipo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($tipos)) { ?>
      <tr>
        <td><?= $row['id_tipo']; ?></td>
        <td><?= $row['nombre_tipo']; ?></td>
        <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_tipo']; ?>">Editar</button>
          <a href="?delete=<?= $row['id_tipo']; ?>" onclick="return confirm('¿Eliminar este tipo?')" class="btn btn-danger btn-sm">Eliminar</a>
        </td>
      </tr>


      <div class="modal fade" id="editModal<?= $row['id_tipo']; ?>" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST">
              <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar Tipo</h5>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id_tipo" value="<?= $row['id_tipo']; ?>">
                <input type="text" name="nombre_tipo" value="<?= $row['nombre_tipo']; ?>" class="form-control" required>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" name="update">Guardar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php } ?>
    </tbody>
  </table>
</div>


<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Nuevo Tipo de Producto</h5>
        </div>
        <div class="modal-body">
          <input type="text" name="nombre_tipo" class="form-control" placeholder="Nombre del tipo" required>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" name="add">Agregar</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
