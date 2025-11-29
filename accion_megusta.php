<?php
session_start();

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    if (!isset($_SESSION["megusta"])) {
        $_SESSION["megusta"] = [];
    }

    // solo se añade si no existe
    if (!isset($_SESSION["megusta"][$id])) {
        $_SESSION["megusta"][$id] = 1;
    }
}

 // Redirigir al index
header("Location: index.php");
?>