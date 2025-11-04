<?php
session_start();
include("conexion.php");

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contraseña = $_POST['contraseña'];
    $rol = "vendedor"; // rol por defecto

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contraseña, rol) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre_usuario, $contraseña, $rol);

    if ($stmt->execute()) {
        header("Location: login.php?err='Usuario registrado correctamente'");
        exit();
    } else {
        $mensaje = "No se pudo registrar el usuario. Revisa que todos los campos estén correctos.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Kiosko Mayorista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Registrarse</h2>

    <?php if ($mensaje != ""): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="registrarse.php">
        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <a href="login.php" class="btn btn-secondary">Volver al login</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
