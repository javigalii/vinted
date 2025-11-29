<?php
    if(isset($_POST['submit'])){
        $nombreFichero = date("Y-m-d - H-i-s"). "-".$_FILES['imagen']['name'];
        $file_loc = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($file_loc,"uploads/".$nombreFichero);
    }
?>