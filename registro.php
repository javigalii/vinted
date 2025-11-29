<?php
require_once "conexion.php";

if (isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Compruebo si el nombre o el email ya están en la base de datos
    $sql = "SELECT * FROM javiusers WHERE username = '$nombre' OR email = '$email'";
    $resultado = $conexion->query($sql);

    // Si ya están, informo del error
    if ($resultado->num_rows > 0) {
        header("location:registro.php?error=1");
        exit;
    }

    // Inserto el nuevo usuario
    $sql = "INSERT INTO javiusers (username, password, email, rol) 
            VALUES ('$nombre', '$password', '$email', 'usuario')";
    $conexion->query($sql);

    header("location:login.php?msj=registrado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registro | Mercadillo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="max-width: 420px; width: 100%;">
        <h2 class="text-center mb-4 text-success">Registro de usuarios</h2>

        <?php
        if (isset($_GET["error"])) {
            echo '<div class="alert alert-danger" role="alert">
                    El nombre o el email ya están registrados. Intenta con otros datos.
                  </div>';
        }
        ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de usuario</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Introduce tu nombre" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Introduce tu email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Introduce tu contraseña" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>

        <p class="mt-3 text-center">
            ¿Ya tienes cuenta?
            <a href="login.php" class="text-decoration-none">Inicia sesión aquí</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
