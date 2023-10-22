<?php
require('../FPDF/fpdf.php');
$dato = $_GET['dato'];
$correo = $_GET['correo'];
$compra = $_GET['compra'];

require "../PHP/conexion.php";
$db = new Database();
$conn = $db->conectar();
$total = 0;
$query = $conn->prepare("SELECT producto.nombre, producto.descripcion, producto.precio, carrito.cantidad
FROM producto INNER JOIN carrito ON producto.id = carrito.id_producto
WHERE carrito.estado = 1 AND carrito.id_usuario = $dato");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
$sql = $conn->prepare("SELECT * FROM usuario WHERE id=$dato");
$sql->execute();
$res = $sql->fetchAll(PDO::FETCH_ASSOC);

$fpdf = new FPDF();
$fpdf->AddPage();
$fpdf->SetFont('Arial', '', 11);

$nombreCliente = $res[0]['nombre'];
$mensajeBienvenida = "Hola $nombreCliente

Agradecemos tu compra en PokeGarden. Esperamos que disfrutes de tus productos. Si necesitas algo mas, no dudes en contactarnos. Gracias por elegirnos

Saludos,
El Equipo de PokeGarden";

$fpdf->MultiCell(0, 10, $mensajeBienvenida);
$fpdf->Ln(); 
$fpdf->Ln(); 
$fpdf->Ln(); 
$fpdf->Ln(); 
$fpdf->Ln(); 
$fpdf->Ln(); 
$fpdf->Image("../IMG/Ty.png", 60, 65, 90, 0); 
$fpdf->Cell(80, 10, 'Desgloce de la Compra'); 
$fpdf->Ln(); 

$fpdf->SetDrawColor(165, 42, 42); 
$fpdf->SetFillColor(165, 42, 42); 
$fpdf->SetTextColor(255, 255, 255); 


$fpdf->Cell(65, 10, 'Nombre', 1, 0, 'C', 1); 
$fpdf->Cell(80, 10, 'Descripcion', 1, 0, 'C', 1); 
$fpdf->Cell(20, 10, 'Cantidad', 1, 0, 'C', 1); 
$fpdf->Cell(25, 10, 'Precio', 1, 0, 'C', 1); 
$fpdf->Ln();


$fpdf->SetDrawColor(165, 42, 42); 
$fpdf->SetFillColor(255, 255, 255); 
$fpdf->SetTextColor(0); 

foreach ($resultado as $row) {
    $nombre = $row['nombre'];
    $descripcion = $row['descripcion'];
    $precio = $row['precio'];
    $cantidad = $row['cantidad'];

    $fpdf->Cell(65, 10, $nombre, 1);
    $fpdf->Cell(80, 10, $descripcion, 1);
    $fpdf->Cell(20, 10, $cantidad, 1);
    $fpdf->Cell(25, 10, $precio, 1);
    $fpdf->Ln();
    $subtotal = $precio * $cantidad;
    $total += $subtotal;
}
$fpdf->SetFillColor(165, 42, 42); 
$fpdf->SetDrawColor(165, 42, 42); 
$fpdf->SetTextColor(255, 255, 255); 

$fpdf->Cell(165, 10, 'Total', 1, 0, 'C', 1); 
$fpdf->SetFillColor(255, 255, 255); 
$fpdf->SetTextColor(0); 
$fpdf->Cell(25, 10, number_format($total, 2), 1, 1, 'C', 1); 
$fpdf ->Close();
   if (!is_dir('../PDF/'.$dato)) {
    if (mkdir('../PDF/'.$dato, 0777)) {
        $fpdf->Output('F','../PDF/'.$dato.'/compra_'.$compra.'.pdf');
        $query = $conn->prepare("UPDATE carrito SET estado=0 WHERE compra=$compra AND id_usuario=$dato");
        $query->execute();
        header("location:envio.php?dato=$dato&correo=$correo");
    } else {
        echo "Hubo un error al crear la carpeta '$dato'.";
    }
} else {
    $fpdf->Output('F','../PDF/'.$dato.'/compra_'.$compra.'.pdf');
    $query = $conn->prepare("UPDATE carrito SET estado=0 WHERE compra=$compra AND id_usuario=$dato");
        $query->execute();
        header("location:envio.php?dato=$dato&correo=$correo&compra=$compra");
}
?>
