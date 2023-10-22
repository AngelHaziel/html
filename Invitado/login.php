<?php
require "../PHP/conexion.php";
$db = new Database();
$conn =$db->conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST)) {
        // Se han enviado datos POST
        $email = $_POST['email']; 
        $pass = $_POST['pass'];

        // Construye la consulta SQL (considera usar consultas preparadas para mayor seguridad)
        $query = "SELECT id FROM usuario WHERE correo='$email' AND contrasena='$pass'";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch();

            if ($row) {
                $dato = $row["id"];
                header("location:../Cliente/index.php?dato=" . urldecode($dato));
            } else if ($email == "Admin@pokegarden.com" && $pass == "Seguro") {
                header("location:../Administrador/index.php");
            } else {
                // No se encontraron coincidencias
                echo "Credenciales incorrectas.";
            }
        } else {
            // Error en la consulta SQL
            echo "Error en la consulta SQL: ";
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
        <form method="POST" action="login.php">
            <h2>Iniciar Sesión</h2>
            <img class="icon" src="../IMG/icon/Poké_Ball_icon.png" alt="">
            <label>
                <i><img class="icon" src="../IMG/icon/pikacho-user-icon.png" alt=""></i>
                <input placeholder="Correo" type="email" id="email" name="email">
            </label>
            <label>
                <i><img class="icon" src="../IMG/icon/lock-solid.svg" alt=""></i>
                <input placeholder="Contraseña" type="password" id="pass" name="pass">
            </label>
            <a class="link" href="registro.php">¿No tienes una cuenta aun?</a>
            <button id="boton"> Iniciar Sesión</button>
        </form>
    </section>
</body>
</html>