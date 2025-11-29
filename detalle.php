<?php
session_start();
require_once "conexion.php";
require_once "funciones.php";

// 1. VALIDACIÓN DE ID Y OBTENCIÓN DE DATOS
if (!isset($_GET["id"])) {
    header("Location: index.php");
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM javiproductos WHERE id = $id";
$resultado = $conexion->query($sql);

if (!$resultado || $resultado->num_rows == 0) {
    header("Location: index.php");
}

$fila = $resultado->fetch_assoc();

$nombre = $fila["nombre"];
$descripcion = $fila["descripcion"];
$precio = $fila["precio"];
$vendedor = $fila["vendedor"];

// Imagen remota o subida
$imagen = (substr($fila["imagen"], 0, 4) === "http")
    ? $fila["imagen"]
    : "uploads/" . $fila["imagen"];

// URL de la página actual
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


// 2. AÑADIR AL CARRITO
if (isset($_POST["idarticulo"])) {

    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    $idArticulo = $_POST["idarticulo"]; 

    if (!isset($_SESSION["carrito"][$idArticulo])) {
        $_SESSION["carrito"][$idArticulo] = 1;
    }
}


// 3. GUARDAR COMENTARIO
if (isset($_POST["enviar_comentario"])) {

    if (!isset($_SESSION["logged"])) {
        exit("Debes iniciar sesión para comentar.");
    }

    $comentario = $_POST["comentario"];
    $producto_id = $id;
    $user_id = $_SESSION["id"];

    $stmt = $conexion->prepare("INSERT INTO javicomentarios (producto_id, user_id, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $producto_id, $user_id, $comentario);
    $stmt->execute();
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title><?php echo $nombre; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="bg-light">

<header class="bg-white shadow-sm mb-4">
    <?php cabezera(); ?>
</header>

<main class="container my-5">

<?php
// Usuario NO logueado
if (!isset($_SESSION["logged"])) {
    echo '
    <div class="alert alert-info text-center">
        Para ver los detalles del producto, <a href="login.php" class="alert-link">inicia sesión</a>.
    </div>';
} else {
?>

    <div class="row bg-white shadow-sm rounded overflow-hidden p-3">

        <!-- IMAGEN -->
        <div class="col-md-7 d-flex align-items-center justify-content-center bg-light rounded"
             style="min-height:450px;">
            <img src="<?php echo $imagen; ?>" 
                 class="img-fluid"
                 style="max-height:450px; object-fit:contain;">
        </div>

        <!-- DATOS -->
        <div class="col-md-5 p-4 d-flex flex-column justify-content-center">

            <h2 class="display-6 fw-bold mb-3"><?php echo $precio; ?> €</h2>
            <h1 class="h4 text-dark mb-4"><?php echo $nombre; ?></h1>

            <hr class="text-muted opacity-25">

            <div class="mb-4">
                <span class="text-muted small text-uppercase fw-bold">Vendedor</span>
                <p class="fs-5 mb-0">
                    <?php 
                    $sql = "SELECT username FROM javiusers WHERE id = $vendedor";

                    $res = $conexion->query($sql);

                    foreach ($res as $fila) {
                        echo $fila['username'];
                    }
                    ?>
                </p>
            </div>

            <div class="mb-4">
                <span class="text-muted small text-uppercase fw-bold">Descripción</span>
                <p class="text-secondary mt-1"><?php echo $descripcion; ?></p>
            </div>

            <hr class="text-muted opacity-25 mb-4">

            <!-- BOTÓN AÑADIR -->
            <form action="" method="POST">
                <input type="hidden" name="idarticulo" value="<?php echo $id; ?>">

                <?php
                        if (isset($_SESSION["carrito"][$id])) {
                            echo '<button type="button" class="btn btn-secondary w-100 py-2" disabled>
                                    Ya añadido al carrito
                                </button>';
                        } else {
                            echo '<button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                    Añadir al carrito
                                </button>';
                        }

                    }
                ?>
            </form>

            <!-- COMPARTIR -->
            <div class="mt-3 text-center">
                <p class="text-muted small mb-1">Compartir:</p>

                <a href="https://wa.me/?text=<?php echo urlencode($nombre . ' ' . $url); ?>"
                   class="btn btn-success btn-sm w-100 mb-2">
                    Compartir por WhatsApp
                </a>

                <a href="mailto:?subject=Mira este producto&body=<?php echo $url; ?>"
                   class="btn btn-outline-dark btn-sm w-100">
                    Enviar por correo
                </a>
            </div>

        </div>
    </div>

<?php 
?>

<h3>Dejar comentario</h3>

<?php
// Si existe la sesión, muestro el formulario
if (isset($_SESSION["logged"])) {
?>
    <form action="" method="POST" class="mb-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Escribe tu comentario</label>
            <textarea name="comentario" class="form-control" rows="3" placeholder="Escribe algo..."></textarea>
        </div>
        <button type="submit" name="enviar_comentario" class="btn btn-primary">
            Enviar
        </button>
    </form>
<?php
} else {
    echo '<div class="alert alert-warning">Tienes que entrar para comentar.</div>';
}
?>

<hr>

<h3 class="mt-4 mb-3">Comentarios anteriores</h3>

<?php
$stmt = $conexion->prepare("
    SELECT * 
    FROM javicomentarios 
    INNER JOIN javiusers ON javicomentarios.user_id = javiusers.id
    WHERE producto_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();


foreach ($resultado as $fila) {
?>
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title mb-1">
                <strong><?php echo $fila['username']; ?></strong> dijo:
            </h6>
            <p class="card-text">
                <?php echo $fila['comentario']; ?>
            </p>
        </div>
    </div>
<?php
}
?>


</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
