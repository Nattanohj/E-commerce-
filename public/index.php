<?php

require_once "../config/database.php";
require_once "../app/models/Usuario.php";
require_once "../app/models/Producto.php";

session_start();
if(isset($_GET['agregar'])){
    $id = $_GET['agregar'];

    if(!isset($_SESSION['carrito'])){
        $_SESSION['carrito']=[];
    }

    $_SESSION['carrito'][] = $id;

    echo "<br>Producto agregado al carrito ";
}


$db = new Database();
$conn = $db->conectar();

$usuario = new Usuario($conn);

// 👇 LOGIN
$usuario->email = "jhonattan@email.com";
$usuario->password = "123456";

$resultado = $usuario->login();

if($resultado){
    $_SESSION['usuario'] = $resultado;
    echo "Login correcto 🎉";
}else{
    echo "Credenciales incorrectas ❌";
}
if(isset($_SESSION['usuario'])){
    echo "<br> Usuario Logueado: " . $_SESSION['usuario']['nombre'];
}

echo "<hr><h2>Lista de productos</h2>";

$producto = new Producto($conn);
$stmt = $producto->listar();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo "Nombre: " . $row['nombre'] . " - Precio: " . $row['precio'];
    echo "<a href='?agregar=" . $row['id_producto'] . "'>Agregar</a><br>";
   
}

echo "<hr><h2>Carrito</h2>";

if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){

    foreach($_SESSION['carrito'] as $id){
        echo "Producto ID: " . $id . "<br>";
    }

}else{
    echo "Carrito vacío";
}