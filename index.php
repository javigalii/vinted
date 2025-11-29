<?php 
session_start();
require_once "conexion.php";
require_once "funciones.php";

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

<body>
<header class="bg-white shadow-sm mb-4">
      <?php
        cabezera();
      ?>
    </header>
<main class="container my-5">
  <?php
    if (!isset($_SESSION["logged"])) {
        echo '
        <div class="alert alert-info text-center" role="alert">
            Para comprar o vender productos, <a href="login.php" class="alert-link">inicia sesión</a> o <a href="registro.php" class="alert-link">regístrate</a>.
        </div>';
    } else {
        // Usuario ha iniciado sesión
        $sql = "SELECT * FROM javiproductos WHERE vendedor <> {$_SESSION['id']}";
        $resultado = $conexion->query($sql);
        
        echo "<div class='row g-4'>"; 
                    
        while($fila = $resultado->fetch_assoc()){
            $nombre = $fila["nombre"];
            $precio = $fila["precio"];
            $imagen = $fila["imagen"];
            $imagen = (substr($imagen, 0, 4) == "http") ? $imagen : "uploads/". $imagen;
            $id = $fila["id"];
            
            $urlDetalle = "detalle.php?id=$id";
            
            echo "<div class='col-md-3'>";
            echo "  <div class='card h-100 text-center shadow-sm border-0'>"; 
            echo "    <a href='$urlDetalle' class='d-block overflow-hidden rounded-top'>";
            echo "      <img src='$imagen' class='card-img-top img-fluid' alt='$nombre' style='height: 250px; object-fit: cover;'>";
            echo "    </a>";
            echo "    <div class='card-body d-flex flex-column justify-content-between'>";
            echo "      <div>";
            echo "        <a href='$urlDetalle' class='text-decoration-none text-dark'>";
            echo "          <h5 class='card-title text-truncate'>$nombre</h5>"; 
            echo "        </a>";
            echo "        <p class='card-text text-secondary fw-bold mb-3'>$precio €</p>";
            echo "      </div>";
            echo "      <div class='d-grid gap-2'>";
            echo "        <a href='megusta.php?id=$id' class='btn btn-outline-danger w-100 rounded-0'>❤️ Me gusta</a>";
            echo "        <a href='$urlDetalle' class='btn btn-outline-dark w-100 rounded-0'>Ver detalles</a>";
            echo "      </div>";
            echo "    </div>";
            echo "  </div>";
            echo "</div>";
        }  
 
        echo "</div>";
    }
  ?>
</main>


<footer>
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
></script>
 
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
></script>
</body>
</html>
