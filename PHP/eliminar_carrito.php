<?php 
require "../PHP/conexion.php";
$db = new Database();
$conn =$db->conectar();
$dato = $_GET["dato"];
$id = $_GET["id"];
$query = $conn->prepare("DELETE FROM carrito WHERE id_producto = $id AND id_usuario = $dato");
$query->execute();
if($query){
    header("location:../Cliente/carrito.php?dato=".urldecode($dato));
}

?>