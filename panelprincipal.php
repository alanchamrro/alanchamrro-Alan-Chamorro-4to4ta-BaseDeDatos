<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
   header("Location: login.php");
   exit;
}

include("conexion.php"); 

if (isset($_GET['err'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    ' . $_GET['err'] . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosko Mayorista - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kiosko Mayorista</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="panelPrincipal.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Usuario: <?= $_SESSION["usuario"];?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-4">
    <h1>Gestión de Productos</h1>
    <a class="btn btn-primary mb-3" href="agregar_producto.php">Agregar nuevo producto</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $resultado = $conexion->query("SELECT productos.*, categorias.nombre_categoria 
                                          FROM productos 
                                          JOIN categorias ON productos.id_categoria = categorias.id");
            while($fila = $resultado->fetch_assoc()) { 
                echo "<tr>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['marca'] . "</td>";
                    echo "<td>" . $fila['nombre_categoria'] . "</td>";
                    echo "<td>$" . number_format($fila['precio_unitario'], 2) . "</td>";
                    echo "<td>" . $fila['stock'] . "</td>";
                    echo "<td>
                        <a class='btn btn-warning btn-sm' href='modificar_producto.php?id=" . $fila['id'] . "'>
                            <span class='material-icons'>update</span>
                        </a>
                        <a class='btn btn-danger btn-sm' href='eliminar_producto.php?id=" . $fila['id'] . "'>
                            <span class='material-icons'>delete</span>
                        </a>
                    </td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</main>

<footer class="text-center mt-4">
    <p>Desarrollado por <?= $_SESSION["usuario"]; ?></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
