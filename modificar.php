<?php
  session_start();
  if(!isset($_SESSION["logged"])){
        header("location:login.php?msj=vender");
      }
  if(isset($_GET["id"])){
    require_once "conexion.php";
    require_once "funciones.php";
    $id = $_GET["id"];

    $sql = "SELECT * FROM javiproductos WHERE id=$id;";
    $resultado = $conexion->query($sql);

    $fila = $resultado->fetch_assoc();

    $nombre = $fila["nombre"];
    $descripcion = $fila["descripcion"];
    $precio = $fila["precio"];
    $categoria = $fila["categoria"];
    $vendedor = $fila["vendedor"];
    $imagen = $fila["imagen"];
  }

  if(isset($_POST["nombre"])){
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $vendedor = $_POST["vendedor"];
    $imagen = $_POST["imagen"];
    $id = $_POST["id"];

    if(isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != ""){
      $imagen = date("Y-m-d - H-i-s") . "-" . $_FILES["imagen"]["name"];
      $file_loc = $_FILES["imagen"]["tmp_name"];
      move_uploaded_file($file_loc, "uploads/" . $imagen);
    }else{
      $imagen = $_POST["imagenActual"];
    }

    $sql = "UPDATE javiproductos SET nombre = '$nombre' , descripcion='$descripcion', precio=$precio, categoria='$categoria', imagen='$imagen' WHERE id=$id;";

    $conexion->query($sql);
    header("location:vender.php");

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

    <body>
        <header class="bg-white shadow-sm mb-4">
      <?php
        cabezera();
      ?>
    </header>
        <main class="container">
      <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
          <h3 class="card-title text-center mb-4">Añade tu artículo</h3>
          <p class="text-muted text-center mb-4">Completa los datos para publicar tu producto en el mercadillo.</p>

          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre del artículo</label>
              <input type="text" name="nombre" id="nombre" class="form-control" required <?php echo $nombre;?>>
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea name="descripcion" rows="4" class="form-control" id="descripcion" required><?php echo $descripcion;?></textarea>
            </div>
            
            <div class="mb-3">
              <label for="precio" class="form-label">Precio (€)</label>
              <input type="number" step="0.01" name="precio" id="precio" class="form-control" required <?php echo $precio;?>>
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen del producto</label>
              <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required >
              <input type="hidden" name="imagenActual" value="<?php echo $imagen;?>">
              <img src="uploads/<?php echo $imagen;?>" style="width: 50px">
            </div>

            <div class="mb-4">
              <label for="categoria" class="form-label">Categoría</label>
              <select class="form-select" name="categoria" id="categoria" required >
                <option value="" selected disabled>Selecciona una categoría</option>
                <option <?php  if($categoria == "Ropa") echo "selected"; ?>>Ropa</option>
                <option <?php  if($categoria == "Tecnología") echo "selected"; ?>>Tecnología</option>
                <option <?php  if($categoria == "Hogar") echo "selected"; ?>>Hogar</option>
                <option <?php  if($categoria == "Otros") echo "selected"; ?>>Otros</option>
              </select>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Publicar artículo</button>
            </div>
          </form>
          </div>
      </div>
    </main>
        <!-- Pie de página -->
    <footer class="text-center py-3 mt-4 text-muted border-top">
      &copy; 2025 Mercadillo - Proyecto Vinted-Copia
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
