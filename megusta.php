<?php 
    session_start();
    require_once "conexion.php";
    require_once "funciones.php";

    // 1. LÓGICA DE AÑADIR/QUITAR (Toggle)
    // Si viene un ID por GET (al pulsar el corazón en el index)
    if(isset($_GET["id"])){
        $id = intval($_GET["id"]);

        // Inicializamos el array si no existe
        if(!isset($_SESSION["megusta"])){
            $_SESSION["megusta"] = [];
        }

        // Si ya existe, lo borramos (funcionalidad de quitar like)
        if(isset($_SESSION["megusta"][$id])){
            unset($_SESSION["megusta"][$id]);
        } else {
            // Si no existe, lo añadimos. Usamos '1' como valor por defecto.
            $_SESSION["megusta"][$id] = 1;
        }

        // Redirigimos a la misma página pero sin el ID para ver la lista limpia
        header("Location: megusta.php");
    }

    // Recuperamos la lista para mostrarla
    if(isset($_SESSION["megusta"])){
        $megusta = $_SESSION["megusta"];
    }
?>

<!doctype html>
<html lang="es">
    <head>
        <title>Mis Me Gusta</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header class="bg-white shadow-sm mb-4">
            <?php cabezera(); ?>
        </header>
        
        <main>
            <div class="container">
                <h2 class="mb-4">❤️ Mis productos favoritos</h2>
                <?php 
                    // Si no hay favoritos o el array está vacío
                    if(!isset($megusta) || count($megusta) == 0){
                        echo "<div class='alert alert-secondary'>No tienes productos en tu lista de 'Me gusta'.</div>";
                    } else {
                        $consulta = "SELECT * FROM javiproductos WHERE ";
                        foreach($megusta as $clave => $valor){
                             $consulta .= "id=$clave OR ";
                        }
                        $consulta = substr($consulta, 0, -3);
                        
                        $resultado = $conexion->query($consulta);
                        
                        echo "<div class='row g-3'>";

                        while($fila = $resultado->fetch_assoc()){ 
                            // Imagen remota o subida
                            $imagen = (substr($fila["imagen"], 0, 4) === "http")
                                ? $fila["imagen"]
                                : "uploads/" . $fila["imagen"];
                            
                            $id = $fila["id"];
                            $nombre = $fila["nombre"];
                            $precio = $fila["precio"];
                            
                            echo "
                            <div class='col-md-6'>
                                <div class='d-flex align-items-center justify-content-between border rounded shadow-sm p-3 bg-white'>
                                    <div class='d-flex align-items-center gap-3'>
                                        <a href='detalle.php?id=$id'>
                                            <img src='{$imagen}' alt='$nombre' class='rounded' style='width: 80px; height: 80px; object-fit: cover;'>
                                        </a>
                                        <div class='lh-1'>
                                            <h5 class='mb-1'><a href='detalle.php?id=$id' class='text-decoration-none text-dark'>$nombre</a></h5>
                                            <p class='text-primary fw-bold mb-0'>$precio €</p>
                                        </div>
                                    </div>
                                    <div class='d-flex flex-column gap-2'>
                                        <a href='detalle.php?id=$id' class='btn btn-sm btn-outline-dark'>Ver detalles</a>
                                        
                                        <a href='megusta.php?id=$id' class='btn btn-sm btn-outline-danger'>💔 Quitar</a>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        echo "</div>";

                        echo "<div class='mt-4'>
                                <a href='index.php' class='btn btn-primary'>Seguir mirando productos</a>
                              </div>";
                    }
                ?>
            </div>
        </main>
        
        <footer>
            </footer>
        
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