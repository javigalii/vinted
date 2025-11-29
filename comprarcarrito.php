<?php 
session_start();
require_once "conexion.php";
require_once "funciones.php";
$totalprecio = isset($_SESSION['totalprecio']) ? $_SESSION['totalprecio'] : 0;
?>

<!doctype html>
<html lang="es">
<head>
    <title>Pago</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
</head>
<body class="bg-light">

    <header class="bg-white shadow-sm mb-4 p-3">
        <?php cabezera(); ?>
    </header>

    <main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h3 class="card-title text-center mb-4">Pagar con PayPal</h3>
            <p class="text-center mb-4">Total a pagar: <strong><?php echo number_format($totalprecio, 2, ',', '.'); ?> €</strong></p>
            
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <!-- Tipo de pago -->
    <input type="hidden" name="cmd" value="_xclick">

    <!-- Tu correo de PayPal Business -->
    <input type="hidden" name="business" value="galianpinerojavier1@gmail.com">

    <!-- Datos del producto -->
    <input type="hidden" name="item_name" value="Compra en mi tienda Vinted">
    <input type="hidden" name="amount" value="<?php echo $totalprecio; ?>">
    <input type="hidden" name="currency_code" value="EUR">

    <!-- URLs de retorno -->
    <input type="hidden" name="return" value="https://tuweb.com/exito.php">
    <input type="hidden" name="cancel_return" value="https://tuweb.com/cancelado.php">

    <button type="submit" class="btn btn-primary w-100 py-2">
        Pagar ahora
    </button>
</form>

        </div>
    </main>

    <footer class="text-center py-3 mt-auto bg-white shadow-sm">
        &copy; <?php echo date('Y'); ?> Mi tienda Vinted
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
