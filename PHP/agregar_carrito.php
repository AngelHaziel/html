<?php
require "../PHP/conexion.php";
$db = new Database();
$conn =$db->conectar();
if (isset($_GET['cantidad'])) {
    $cantidad = $_GET['cantidad'];
}
if (isset($_GET['dato'])) {
    $dato = $_GET['dato'];
}
if (isset($_GET['id'])) {
    $id = $_GET['id']; 
}

$query = "SELECT COUNT(*) AS total_registros FROM carrito";
$result = $conn->query($query);
if ($result) {
    $row = $result->fetch();
    $totalRegistros = $row['total_registros'];
    if ($totalRegistros > 0) {
        $query3 = "SELECT COUNT(*) AS registros_con_uno FROM carrito WHERE estado = 1 AND id_usuario = $dato";
        $result3 = $conn->query($query3);
        if($result3){
            $row2 = $result3->fetch();
            $registrosConUno = $row2['registros_con_uno'];
            if ($registrosConUno > 0) {
                //hay una compra activa
                $query2 = "SELECT MAX(compra) AS numero_maximo FROM carrito WHERE id_usuario = $dato";
                $result2 = $conn->query($query2);
                if ($result2) {
                    $query = "SELECT COUNT(*) AS count FROM carrito WHERE id_producto = $id AND id_usuario = $dato";
                    $result = $conn->query($query);
                    if ($result) {
                        $row = $result->fetch();
                        if ($row['count'] > 0) {
                                $update_query = "UPDATE carrito SET cantidad = cantidad + $cantidad WHERE id_producto = $id AND id_usuario = $dato";
                                $conn->query($update_query);
                                header("location:../Cliente/producto.php?dato=".urldecode($dato));
                        }else{
                            $row3 = $result2->fetch();
                            $numeroMaximo = $row3['numero_maximo'];
                            $sql2 = $conn->prepare("INSERT INTO carrito (estado,compra,id_usuario,id_producto,cantidad) values (1,'$numeroMaximo','$dato','$id','$cantidad')");
                            $sql2->execute();
                            if($sql2){
                                header("location:../Cliente/producto.php?dato=".urldecode($dato));
                            }
                        }
                    }
                    
                }
            }else{
                //no hay una compra activo
                $query2 = "SELECT MAX(compra) AS numero_maximo FROM carrito WHERE id_usuario = $dato";
                $result2 = $conn->query($query2);
                if ($result2) {
                    $row4 = $result2->fetch();
                    $numeroMaximo = $row4['numero_maximo'] + 1;
                    $sql2 = $conn->prepare("INSERT INTO carrito (estado,compra,id_usuario,id_producto,cantidad) values (1,'$numeroMaximo','$dato','$id','$cantidad')");
                    $sql2->execute();
                    if($sql2){
                        header("location:../Cliente/producto.php?dato=".urldecode($dato));
                    }else{
                        echo "valio verga padrino";
                    }
                }
            }
        }
    } else {
        $sql = $conn->prepare("INSERT INTO carrito (estado,compra,id_usuario,id_producto,cantidad) values (1,1,'$dato','$id','$cantidad')");
        $sql->execute();
        if($sql){
            header("location:../Cliente/producto.php?dato=".urldecode($dato));
        }else{
            echo "valio verga padrino";
        }
    }
} else {
    echo "Error en la consulta: ";
}


?>



