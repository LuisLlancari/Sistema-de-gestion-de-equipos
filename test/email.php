<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


function enviarMail($emailDestino="", $mensaje=""){
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  $estado = ["enviado" => false];
  
  try {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'miguel.llancari12@gmail.com';                     //SMTP username
      $mail->Password   = 'dlgonnlzucbyxchm';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
      //Recipients
      $mail->setFrom('sistemas@gmail.com', 'Administrador');
      // $mail->addAddress('1393241@senati.pe', 'Joe User');     //Add a recipient
      $mail->addAddress($emailDestino);               //Name is optional
      // $mail->addReplyTo('info@example.com', 'Information'); //Respuesta
      // $mail->addCC('cc@example.com'); //Agregar Copia
      // $mail->addBCC('bcc@example.com'); //Agregar copia Oculta
  
      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
  
      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject ='SISTEMA COMPUTARIZADO DE GESTION DE MANTENIMIENTO';
      $mail->Body    = "
          <h3>Buen día: </h3> 
          <p> <strong>$mensaje</strong> es tu código de verificación, úsalo para el cambio de contraseña.</p>";
      ;
      $mail->AltBody = 'Tu correo no soporta HTML, por favor comunicarse...';
  
      $mail->send();
      // echo 'Message has been sent';
      $estado["enviado"] = true;
    } catch (Exception $e) {
      $estado["enviado"] = false;
      // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

?>
