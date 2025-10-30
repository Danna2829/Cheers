<?php
session_start();
if ($_SESSION['rol'] != 'admin') header("Location: index.php");
include("conexion.php");

// Crear producto
if (isset($_POST['add'])) {
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];
    $stock       = $_POST['stock'];
    $id_tipo     = $_POST['id_tipo'];

    $stmt = mysqli_prepare($conn, "INSERT INTO productos (nombre, descripcion, precio, stock, id_tipo) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdii", $nombre, $descripcion, $precio, $stock, $id_tipo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: productos.php");
    exit;
}

// Actualizar producto
if (isset($_POST['update'])) {
    $id          = $_POST['id_producto'];
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];
    $stock       = $_POST['stock'];
    $id_tipo     = $_POST['id_tipo'];

    $stmt = mysqli_prepare($conn, "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, id_tipo=? WHERE id_producto=?");
    mysqli_stmt_bind_param($stmt, "ssdiii", $nombre, $descripcion, $precio, $stock, $id_tipo, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: productos.php");
    exit;
}

// Eliminar producto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (is_numeric($id)) {
        $stmt = mysqli_prepare($conn, "DELETE FROM productos WHERE id_producto=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: productos.php");
    exit;
}

// Consultas de productos y tipos
$productos = mysqli_query($conn, "SELECT p.*, t.nombre_tipo FROM productos p JOIN tipos_productos t ON p.id_tipo=t.id_tipo");
$tipos     = mysqli_query($conn, "SELECT * FROM tipos_productos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">Gestión de Productos</span>
  <div>
    <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm">Volver</a>
    <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de productos</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Nuevo Producto</button>
  </div>

  <table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Tipo</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($productos)) { ?>
      <tr>
        <td><?= $row['id_producto']; ?></td>
        <td><?= $row['nombre']; ?></td>
        <td><?= $row['descripcion']; ?></td>
        <td><?= $row['nombre_tipo']; ?></td>
        <td>Bs <?= $row['precio']; ?></td>
        <td><?= $row['stock']; ?></td>
        <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_producto']; ?>">Editar</button>
          <a href="?delete=<?= $row['id_producto']; ?>" onclick="return confirm('¿Eliminar este producto?')" class="btn btn-danger btn-sm">Eliminar</a>
        </td>
      </tr>

      <!-- Modal Editar -->
      <div class="modal fade" id="editModal<?= $row['id_producto']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="POST">
              <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar Producto</h5>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id_producto" value="<?= $row['id_producto']; ?>">
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label>Nombre</label>
                    <input class="form-control" name="nombre" value="<?= $row['nombre']; ?>" required>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Tipo</label>
                    <select name="id_tipo" class="form-select" required>
                      <?php 
                      $tipos2 = mysqli_query($conn, "SELECT * FROM tipos_productos");
                      while($t = mysqli_fetch_assoc($tipos2)) {
                        $sel = $t['id_tipo']==$row['id_tipo'] ? 'selected' : '';
                        echo "<option value='{$t['id_tipo']}' $sel>{$t['nombre_tipo']}</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 mb-2">
                    <label>Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="2"><?= $row['descripcion']; ?></textarea>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Precio</label>
                    <input type="number" class="form-control" name="precio" value="<?= $row['precio']; ?>" required>
                  </div>
              
                </div>
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

<!-- Modal Agregar -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Nuevo Producto</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label>Nombre</label>
              <input class="form-control" name="nombre" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tipo</label>
              <select name="id_tipo" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php while($t = mysqli_fetch_assoc($tipos)) echo "<option value='{$t['id_tipo']}'>{$t['nombre_tipo']}</option>"; ?>
              </select>
            </div>
            <div class="col-12 mb-2">
              <label>Descripción</label>
              <textarea class="form-control" name="descripcion" rows="2"></textarea>
            </div>
            <div class="col-md-6 mb-2">
              <label>Precio</label>
              <input type="number" class="form-control" name="precio" required>
            </div>
      
          </div>
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

