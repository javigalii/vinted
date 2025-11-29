<?php
session_start();
    if(isset($_POST["nombre"])){
        $nombre = $_POST["nombre"];
        $password = $_POST["password"];
        // Si el nombre lleva una arriba, en un email y cosulto los email
        if(str_contains($nombre, "@")){
            $campo ="email";
            $consulta = "SELECT * FROM javiusers WHERE email='$nombre' AND password='$password'";
        }else{
            // Si el nombre no lleva arroba, comparo con los username
            $campo = "username";
            $consulta = "SELECT * FROM javiusers WHERE username='$nombre' AND password='$password'";

        }

        require_once("conexion.php");
        // Comppleto la consulta a la base de datos
        $resultado = $conexion->query($consulta);
        // Si hay algún regustro que tenga ese nombre y ese password
        if($resultado->num_rows>0){
            // Recupero todos los campos del registro que cumple la consulta y los guardo en un array asociativo
            $fila = $resultado->fetch_assoc();
            // Guardo en una variable de sessión el id y el usuario para que 
            $_SESSION["id"] = $fila["id"];
            $_SESSION["logged"] = true;
            header("location:index.php");
        }else{
            header("location:login.php?error=1");
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Vinted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4 text-primary">Iniciar sesión</h2>

        <?php
        if (isset($_GET["msj"]) && $_GET["msj"] == "registrado") {
            echo '<div class="alert alert-success" role="alert">
                    Ya estás registrado. Ahora puedes entrar en la aplicación.
                  </div>';
        }

        if (isset($_GET["msj"]) && $_GET["msj"] == "vender") {
            echo '<div class="alert alert-danger" role="alert">
                    Para poder vender tienes que estar logeado
                  </div>';
        }

        if (isset($_GET["error"]) && $_GET["error"] == 1) {
            echo '<div class="alert alert-danger" role="alert">
                    El nombre de usuario o la contraseña no son correctos.
                  </div>';
        }
        ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Usuario o correo electrónico</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escribe tu nombre o email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Escribe tu contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <p class="mt-3 text-center">
            ¿No tienes cuenta?
            <a href="registro.php" class="text-decoration-none">Regístrate aquí</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>