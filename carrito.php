<?php 
    session_start();
    require_once "conexion.php";
    require_once "funciones.php";
    if(isset($_SESSION["carrito"])){
        $carrito = $_SESSION["carrito"];
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Carrito</title>
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
        <main>
            <div class="container">
            <?php 
                if(!isset($carrito) || count($carrito)== 0){
                    echo "El carrito esta vacío";
                }else{
                    $consulta = "SELECT * FROM javiproductos WHERE ";
                    foreach($carrito as $clave => $valor){
                         $consulta .= "id=$clave OR ";
                    }
                    $consulta = substr($consulta, 0, -3);
                    $resultado = $conexion->query($consulta);
                    $totalprecio = 0;
                    
                    while($fila = $resultado->fetch_assoc()){ 
                        // Imagen remota o subida
                        $imagen = (substr($fila["imagen"], 0, 4) === "http")
                            ? $fila["imagen"]
                            : "uploads/" . $fila["imagen"];
                    echo "
                    <div class='d-flex align-items-center justify-content-between border rounded shadow-sm p-2 mb-2 bg-light'>
                        <div class='d-flex align-items-center gap-2'>
                            <img src='{$imagen}' alt='{$fila["nombre"]}' class='rounded' style='width: 50px; height: 50px; object-fit: cover;'>
                            <div class='lh-1'>
                                <h6 class='mb-0'>{$fila['nombre']}</h6>
                                <small class='text-muted'>ID: {$fila['id']}</small>
                            </div>
                        </div>
                        <div class='text-end lh-1'>
                            <strong class='text-success small'>Total: " . ($carrito[$fila["id"]] * $fila["precio"]) . " €</strong>
                        </div>
                    </div>
                    ";
                    $totalprecio += $fila["precio"];

                }
                $_SESSION["totalprecio"] = $totalprecio;
                echo "<div class='row mt-3'>
                    <div class='col'>
                        <div class='p-3 bg-dark text-white rounded shadow-sm'>
                            <h4 class='mb-0'>Total: $totalprecio €</h4>
                        </div>
                    </div>
                </div>";

                echo "<div class='row mt-3'>
                    <div class='col d-flex gap-2'>
                        <a href='comprarcarrito.php?totalprecio=$totalprecio' class='btn btn-success px-4 py-2 fw-semibold shadow-sm'>
                            Comprar
                        </a>
                        <a href='vaciarcarrito.php' class='btn btn-warning px-4 py-2 fw-semibold shadow-sm'>
                            Vaciar
                        </a>
                    </div>
                </div>";

                }
            ?>
            </div>
        </main>
        <footer>
            <!-- place footer here -->
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
