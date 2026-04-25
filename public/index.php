<?php

require_once "../config/database.php";

$db = new Database();
$conn = $db->conectar();

if ($conn) {
    echo "Conexión exitosa a la BD 🎉";
} else {
    echo "Error de conexión ❌";
}