<?php
require "../PHP/conexion.php";
$db = new Database();
$conn =$db->conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST)) {
        // Se han enviado datos POST
        $nombre = $_POST['nom'];
        $telefono = $_POST['tel'];
        $email = $_POST['email']; 
        $pass = $_POST['pass'];
        $sql = $conn->prepare("INSERT INTO usuario (id,nombre,telefono,correo,contrasena) values (0,'$nombre','$telefono','$email','$pass')");
        $sql->execute();
        if($sql){
            header("location: login.php");
        }else{
            echo "No se pudo ingresar";
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/registro.css">
    <link rel="stylesheet" href="../CSS/barra_nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <title>PokeGarden</title>
</head>
<body>
    <header class="header_index">
        <nav class="nav">
            <div class="logo"><a href="../index.html">PokeGarden</a></div>
            <ul class="menu">
                <li><a href="ubicacion.html">Ubicación</a></li>
                <li><a href="producto.php">Productos</a></li>
                <li><a href="registro.php">Registrar</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <section class="login">
        <form method="POST" action="registro.php">
            <h2>Registrate</h2>
            <img class="icon" src="../IMG/icon/Poké_Ball_icon.png" alt="">
            <label>
                <i><img class="icon" src="../IMG/icon/pikacho-user-icon.png" alt=""></i>
                <input placeholder="Nombre" type="text" id="nom" name="nom">
            </label>
            <label>
                <i><img class="icon" src="../IMG/icon/mobile-retro-solid.svg" alt=""></i>
                <input placeholder="Telefono" type="text" id="tel" name="tel">
            </label>
            <label>
                <i><img class="icon" src="../IMG/icon/square-envelope-solid.svg" alt=""></i>
                <input placeholder="E-mail" type="email" id="email" name="email">
            </label>
            <label>
                <i><img class="icon" src="../IMG/icon/lock-solid.svg" alt=""></i>
                <input placeholder="Contraseña" type="password" id="pass" name="pass">
            </label>
            </label>
            <a class="link" href="login.php">Ya tengo una cuenta</a>
            <button id="boton"> Registrame</button>
        </form>
    </section>
</body>
</html>