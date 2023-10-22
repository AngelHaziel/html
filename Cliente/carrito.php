<?php 
require "../PHP/conexion.php";
$db = new Database();
$conn =$db->conectar();
$dato = $_GET["dato"];
$total = 0;
$query = $conn->prepare ("SELECT producto.id, producto.nombre, producto.descripcion, producto.precio, carrito.compra, carrito.cantidad, carrito.estado
FROM producto INNER JOIN carrito ON producto.id = carrito.id_producto
WHERE carrito.estado = 1 AND carrito.id_usuario = $dato");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
$sql = $conn->prepare("SELECT * FROM usuario WHERE id=$dato");
$sql->execute();
$res = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/carrito.css">
    <link rel="stylesheet" href="../CSS/barra_nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <title>PokeGarden</title>
</head>
<body>
<header class="header_index">
        <nav class="nav">
            <div class="logo"><a href="index.php?dato=<?php echo $dato ?>">PokeGarden</a></div>
            <ul class="menu">
                <li><a href="ubicacion.php?dato=<?php echo $dato ?>">Ubicación</a></li>
                <li><a href="producto.php?dato=<?php echo $dato ?>">Productos</a></li>
                <li><a href="carrito.php?dato=<?php echo $dato ?>">Carrito</a></li>
                <li><a href="#?dato=<?php echo $dato ?>">Ver Compras</a></li>
                <li><a href="../index.html">Cerrar Sesión</a></li>
                <li><img class="icon" src="../IMG/icon/usuario.png" alt=""></li>
            </ul>
        </nav>
    </header>
    <section class="cuerpo">
        <h2>Datos de la compra</h2>
        <table class="tabla">
            <tr><th>Producto</th><th>Descripción</th><th>Cantidad</th><th>Precio/u</th><th></th></tr>
            <?php foreach($resultado as $row){ ?>
                <?php 
                    $estado = $row['estado'];
                    $can = $row['cantidad'] * $row['precio'];
                    $total = $total + $can;
                    $compra = $row['compra'];
                ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><a class="button" href="../PHP/eliminar_carrito.php?dato=<?php echo $dato ?>&id=<?php echo $row['id'] ?>">Eliminar</a></td>
            </tr>
            <?php }?>
            <tr>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><?php echo $total ?></td>
            </tr> 
        </table>
        <h1>Datos personales</h1>
        <table class="tabla">
        <tr><th>Nombre</th><th>Email</th><th>Telefono</th></tr>
        <?php foreach($res as $row){?>
                <?php 
                    $correo = $row['correo'];
                    ?>
                <tr>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php echo $row['correo'];?></td>
                    <td><?php echo $row['telefono'];?></td>
                </tr>
            <?php } ?> 
        </table>
        <a class="button" href="producto.php?dato=<?php echo $dato ?>">Regresar</a>
        <a class="button" href="../PHP/GenerarPDF.php?dato=<?php echo $dato ?>&correo=<?php echo $correo ?>&compra=<?php echo $compra ?>">Imprimir</a>
    </section>
</body>
</html>