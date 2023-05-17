<?php

class mailing
{
  // public function sendMail($to, $subject, $message){
  public function sendMail()
  {

    $to = "sergiofs19@gmail.com";
    $subject = "Hola que tal";

    $message = "<b>Esto es un mensaje de prueba</b>";

    $header = "From:sergiofs19@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail($to, $subject, $message, $header);

    if ($retval == true) {
      echo "Mensaje enviado correctamente...";
    } else {
      echo "Error al enviar el mensaje...";
    }
  }
}
