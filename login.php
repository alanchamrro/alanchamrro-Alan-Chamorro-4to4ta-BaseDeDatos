<?php
session_start(); 

include("conexion.php");

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

  
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario=? AND contraseña=?");
    $stmt->bind_param("ss", $usuario, $contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['loggedin'] = true;
        header("Location: panelPrincipal.php");
        exit();
    } else {
        $mensaje = "Credenciales incorrectas.";
    }

    $stmt->close();
}


if (isset($_GET['err'])) {
    $mensaje = $_GET['err'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kiosko Mayorista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if ($mensaje != ""): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Ingresar</button>
                <a class="btn btn-secondary" href="registrarse.php">Registrarse</a>
            </div>
        </form>
    </div>
</body>
</html>

