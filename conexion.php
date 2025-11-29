<?php
$usuario = "root";
$password = "2004Jjaa";
$basededatos = "vinted";
$conexion = new mysqli("localhost", $usuario, $password, $basededatos);
if($conexion->connect_errno){
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear tabla USERS
$conexion->query("CREATE TABLE IF NOT EXISTS javiusers(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    create_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Crear tabla PRODUCTOS
$sql = "CREATE TABLE IF NOT EXISTS javiproductos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    precio DECIMAL(8,2),
    vendedor INT,
    vendido BOOLEAN,
    categoria VARCHAR(255),
    imagen VARCHAR(255),
    CONSTRAINT fk_vendedor FOREIGN KEY (vendedor) REFERENCES javiusers(id)
)";
$conexion->query($sql);

// Crear tabla de COMENTARIOS
$sql = "CREATE TABLE IF NOT EXISTS javicomentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    user_id INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES javiproductos(id),
    FOREIGN KEY (user_id) REFERENCES javiusers(id)
)";
$conexion->query($sql);



// // Insertar usuario admin si no existe
// $resultado = $conexion->query("SELECT * FROM javiusers");
// if(!$resultado->fetch_object()){
//     $conexion->query("INSERT INTO javiusers VALUES (NULL, 'admin', '123', 'admin', 'galianpinerojavier@gmail.com', NULL)");
// }
?>
