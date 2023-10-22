<!DOCTYPE html>
<html>
<head>
    <title>Lista de archivos PDF</title>
</head>
<body>
    <h1>Archivos PDF en el Directorio</h1>
    <ul>
        <?php
        // Directorio donde se encuentran los archivos PDF
        $directorio = 'PDF/';

        // Escanea el directorio para obtener una lista de archivos
        $archivos = scandir($directorio);

        // Filtra los archivos PDF
        $archivos_pdf = array_filter($archivos, function($archivo) {
            return pathinfo($archivo, PATHINFO_EXTENSION) === 'pdf';
        });

        // Muestra los enlaces a los archivos PDF en una lista
        foreach ($archivos_pdf as $pdf) {
            echo '<li><a href="' . $directorio . $pdf . '" target="_blank">' . $pdf . '</a></li>';
        }
        ?>
    </ul>
</body>
</html>