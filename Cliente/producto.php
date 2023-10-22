<?php 
require "../PHP/conexion.php";
$dato = $_GET["dato"];
$db = new Database();
$conn =$db->conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST)) {
        $nombre = $_POST['nombre'];
        $sql = $conn->prepare("SELECT id, link, nombre, precio FROM producto WHERE nombre LIKE '%$nombre%'");
        
    }
} else {
    $sql = $conn->prepare("SELECT id, link, nombre, precio FROM producto");
}
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/producto.css">
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
                <li><img style="height: 2.5em; margin-top: -0.5em;" src="../IMG/icon/usuario.png" alt=""></li>
            </ul>
        </nav>
    </header>
    <section class="cuerpo">
        <br>
        <form method="POST" action="producto.php">
            
            <div>
            <h2 class="tittle" >Buscar Producto</h2>
            <label>
                <i><img class="icon" src="../IMG/icon/pikacho-user-icon.png" alt=""></i>
                <input placeholder="Nombre" type="text" id="nombre" name="nombre">
            </label>
            </div>
            <button id="busqueda" name="busqueda"> Buscar</button>
        </form>
        <br>
        <div class="cont_index">
        <?php foreach($resultado as $row){ ?>
            <?php
                $name = $row['link']; 
                $imagen = "../IMG/productos/".$name; 
            ?> 
        <div class="cont_carta">
            <div class="cont_img">
            <img src="<?php echo $imagen; ?>" >
            </div>
            <div class="cont_texto_c">
            <h2 style="font-size: 1.5em; margin-top: 0.5em;  margin-left: 0.5em;"><?php echo $row['nombre'];?></h2>
            <p style="font-size: 1.3em; margin-top: -0.5em; margin-left: 0.5em;"> $ <?php echo $row['precio'];?>"</p>
            <div style="margin-left: 0.5em;">
            <label for="cantidad">Cantidad:</label>
            <script>var dato = <?php echo json_encode($dato); ?>; </script>
            <script src="../JS/redireccionar.js"> </script>
            <input class="caja" type="number" id="cantidad" name="cantidad" min="0" max="100" step="1" value="0">
            <a class="button" href="#" data-product-id="<?php echo $row['id']; ?>" data-dato="<?php echo $dato; ?>">Agregar</a>
            </div>   
            </div>
        </div>
        <?php }?>

        </div>
    </section>
</body>
</html>