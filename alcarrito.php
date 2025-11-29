<?php 
    session_start();
    // Si me pasan la variable con el id del artículo, procedo
    if(isset($_GET["id"])){
        $id = $_GET["id"];

        // Compruebo si existe la variable de session carrito
        if(isset($_SESSION["carrito"])){
            // Si existe, la guardo en la variable $carrito
            $carrito = $_SESSION["carrito"];
        }else{
            // si no existe, la creo como un array vacío
            $_SESSION["carrito"] = [];  
        }
        $carrito[$id] = 1;
        // Una vez modificada la variable vuelvo a guardarla en la variable de sesion
        $_SESSION["carrito"] = $carrito;
        header("location: index.php");
    }