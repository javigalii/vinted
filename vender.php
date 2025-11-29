<?php
    session_start();
    require_once "conexion.php";
    require_once "funciones.php";
    if(!isset($_SESSION["logged"])){
      header("location:login.php?msj=vender");
    }

    if(isset($_POST["nombre"])){
        $nombre = $_POST["nombre"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];
        $descripcion = $_POST["descripcion"];
        // EL id del uusuario vendedor lo recupero de la variable de sesión a la que le he dado el valor en login.php
        $vendedor = $_SESSION["id"];

        // $_FILES se llama imagen porque el control de tipo del formulario se llama imagen 
        $imagen = date("Y-m-d - H-i-s") . "-" . $_FILES["imagen"]["name"];
        $file_loc = $_FILES["imagen"]["tmp_name"];
        move_uploaded_file($file_loc, "uploads/" . $imagen);

        $sql = "INSERT INTO javiproductos (nombre, descripcion, precio, imagen, categoria, vendedor, vendido)";
        $sql .= " VALUES ('$nombre' , '$descripcion', $precio, '$imagen', '$categoria', '$vendedor', 0);";

        $conexion->query($sql);
    }
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

          <body class="bg-light">

    <!-- Encabezado -->
<header class="bg-white shadow-sm mb-4">
      <?php
        cabezera();
      ?>
    </header>

    <!-- Contenido principal -->
<main class="container">
  <div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Añade tu artículo</h3>
      <p class="text-muted text-center mb-4">Completa los datos para publicar tu producto en el mercadillo.</p>

      <form action="" method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre del artículo</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea name="descripcion" rows="4" class="form-control" id="descripcion" required></textarea>
        </div>
        
        <div class="mb-3">
          <label for="precio" class="form-label">Precio (€)</label>
          <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen del producto</label>
          <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
        </div>

        <div class="mb-4">
          <label for="categoria" class="form-label">Categoría</label>
          <select class="form-select" name="categoria" id="categoria" required>
            <option value="" selected disabled>Selecciona una categoría</option>
            <option>Ropa</option>
            <option>Tecnología</option>
            <option>Hogar</option>
            <option>Otros</option>
          </select>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Publicar artículo</button>
        </div>
      </form>

      <?php
        $vendedor = $_SESSION["id"];
        $sql = "SELECT * FROM javiproductos WHERE vendedor=$vendedor;";

        $resultado = $conexion->query($sql);

        while($fila = $resultado->fetch_assoc()){
            $imagen = $fila["imagen"];
            $imagen = substr($imagen, 0, 4) == "http" ? $imagen : "uploads/" . $imagen;
            $idArticulo = $fila["id"];
            
             
            echo "<div class='card shadow-sm mb-3 border-0'>";
            echo "  <div class='d-flex align-items-center p-2'>";
            echo "    <div class='flex-shrink-0 me-3' style='width: 80px;'>";
            echo "      <img src='$imagen' class='img-fluid rounded' alt='Imagen del producto'>";
            echo "    </div>";
            echo "    <div class='flex-grow-1'>";
            
            if($fila['vendido']){
              echo "      <h6 class='text-secondary mb-0'>{$fila['nombre']}</h6>";
            } else {
              echo "      <h6 class='mb-0'><a href='modificar.php?id=$idArticulo' class='text-decoration-none'>{$fila['nombre']}</a></h6>";
            }

            echo "    </div>";
            echo "  </div>";
            echo "</div>";
           
        }
      ?>
    </div>
  </div>
</main>

    <!-- Pie de página -->
    <footer class="text-center py-3 mt-4 text-muted border-top">
      &copy; 2025 Mercadillo - Proyecto Vinted-Copia
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>
