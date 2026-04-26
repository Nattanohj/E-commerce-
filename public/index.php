<?php

require_once "../config/database.php";
require_once "../app/models/Usuario.php";

$db = new Database();
$conn = $db->conectar();

$usuario = new Usuario($conn);

// 👇 CREAR USUARIO (solo para prueba)
$usuario->nombre = "Jhonattan";
$usuario->email = "jhonattan@email.com";
$usuario->password = "123456";
$usuario->direccion = "Chile";

//$usuario->crear();

echo "Usuario creado <br>";

// 👇 LOGIN
$usuario->email = "jhonattan@email.com";
$usuario->password = "123456";

$resultado = $usuario->login();

if($resultado){
    echo "Login correcto 🎉";
}else{
    echo "Credenciales incorrectas ❌";
}