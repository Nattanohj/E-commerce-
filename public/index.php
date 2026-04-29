<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "../config/database.php";
require_once "../app/models/Usuario.php";
require_once "../app/models/Producto.php";


$db = new Database();
$conn = $db->conectar();

if(!$conn){
    die("Error de conexión a la BD");
}


if(isset($_GET['agregar'])){
    $id = $_GET['agregar'];

    if(!isset($_SESSION['carrito'])){
        $_SESSION['carrito'] = [];
    }

    $_SESSION['carrito'][] = $id;

    header("Location: index.php");
    exit();
}


if(isset($_GET['vaciar'])){
    unset($_SESSION['carrito']);
    header("Location: index.php");
    exit();
}


$usuario = new Usuario($conn);
$usuario->email = "jhonattan@email.com";
$usuario->password = "123456";

$resultado = $usuario->login();

if($resultado){
    $_SESSION['usuario'] = $resultado;
}


$producto = new Producto($conn);
$stmt = $producto->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


<div class="login">
    <h2>Login</h2>

    <?php if(isset($_SESSION['usuario'])): ?>
        <p>Bienvenido: <?php echo $_SESSION['usuario']['nombre']; ?></p>
    <?php else: ?>
        <p>No logueado</p>
    <?php endif; ?>
</div>

<hr>


<div class="productos">
    <h2>Productos</h2>

    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>

        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td>
                    <a href="?agregar=<?php echo $row['id_producto']; ?>">
                        <button>Agregar</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>
</div>

<hr>


<div class="carrito">
    <h2>Carrito</h2>

    <?php if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>

        <?php foreach($_SESSION['carrito'] as $id): ?>
            <p>Producto ID: <?php echo $id; ?></p>
        <?php endforeach; ?>

    <?php else: ?>
        <p>Carrito vacío</p>
    <?php endif; ?>

    <br>
    <a href="?vaciar=true">
        <button>Vaciar carrito</button>
    </a>
</div>

</body>
</html>