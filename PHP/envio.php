<?php
$dato = $_GET['dato'];
$correo = $_GET['correo'];
$compra = $_GET['compra'];
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMAiler/Exception.php';
require '../PHPMAiler/PHPMailer.php';
require '../PHPMAiler/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'a21310382@ceti.mx';                     //SMTP username
    $mail->Password   = 'brgh qyjh pcbp bict';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('a21310382@ceti.mx', 'Pokegarden');
    $mail->addAddress($correo);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    

    //Attachments
    $add = "../PDF/".$dato."/compra_".$compra.".pdf";
    $mail->addAttachment($add);         //Add attachments
    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Gracias por su compra';
    $mail->Body    = 'Seguro es una persona guapisima, por eso compro en nuestro sistema. Besis de fresi <3';

    $webdavUrl = 'http://10.0.0.7/PDF/'.$dato.'/compra_'.$compra.'.pdf';  
$webdavUsername = 'root';  
$webdavPassword = '1234';  

$localPdfPath = '../PDF/'.$dato.'/compra_'.$compra.'.pdf';  

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webdavUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$webdavUsername:$webdavPassword");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($localPdfPath));
$response = curl_exec($ch);
if ($response === false) {
    echo "Error en la transferencia: " . curl_error($ch);
} else {
    echo "Transferencia exitosa.";
}
curl_close($ch);
    $mail->send();
    header("Location:../Cliente/producto.php?dato=$dato");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>