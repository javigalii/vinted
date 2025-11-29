<?php 
function escribirCantidadCarrito(){
    $cantidad = 0;

    if(isset($_SESSION["carrito"])){
        $carrito = $_SESSION["carrito"];

        foreach($carrito as $clave=>$valor){
            $cantidad += $valor;
        }
    }
    return $cantidad;
}

function escribirCantidadMeGusta(){
    $cantidad = 0;
    if(isset($_SESSION["megusta"])){
        $cantidad = count($_SESSION["megusta"]);
    }
    return $cantidad;
}

function cabezera(){
    echo "<div class='container py-3'>";
        echo "<div class='row align-items-center'>";
            echo "<div class='col-2'>";
                echo "<a href='index.php' class='text-decoration-none text-primary fw-semibold'>Comprar</a>";
            echo "</div>";
            echo "<div class='col-6 text-center'>";
                echo "<h1 class='h3 text-dark m-0'>🛍️ Mercadillo</h1>";
            echo "</div>";
            echo "<div class='col-2 text-end'>";
                echo "<a href='vender.php' class='btn btn-outline-primary btn-sm'>Vender</a>";
            echo "</div>";
            echo "<div class='col-1 text-center'>";
                echo "<a href='megusta.php' style='font-size: 28px; color:red;'>❤️</a>";
            echo "</div>";
            echo "<div class='col-1'>";
                echo "<a href='carrito.php' style='font-size: 40px;'>🛒</a>" . escribirCantidadCarrito();
            echo "</div>";
        echo "</div>";
    echo "</div>";
}
