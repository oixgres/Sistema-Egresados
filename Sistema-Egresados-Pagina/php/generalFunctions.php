<?php
  /* Funcion para generar claves */
  function generateCode($conn, $id, $isNew)
  {
    /* Si la clave no es nueva borramos la existente */
    if(!is_null($isNew))
      mysqli_query($conn, "DELETE * FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$id."'");

    /* Creamos la clave de acceso */
    $key = rand(10000000, 99999999);
    $key = strval($key);

    /* Insertamos la nueva clave a la BD */
    mysqli_query($conn, "INSERT INTO Claves_Confirmacion (Usuario_idUsuario, Clave) VALUES('$id', '$key')");

    return $key;
  }

  /* Funcion para enviar claves por correo */
  function sendCode($conn, $email, $issue, $key)
  {
    /* Mensaje para el correo */
    $mailMessage = "Este es el ultmo paso para crear tu cuenta!"."\r\n";
    $mailMessage.= "Por favor ingresa la siguiente clave en la pagina para activar tu cuenta"."\r\n";
    $mailMessage.= $key."\r\n\n";
    $mailMessage.= "NOTA: Si usted no creado una cuenta solo ignore el mensaje";

    /* Preparamos el correo */
    $header = "FROM: noreply@SistemaEgresados.com"."\r\n";
    $header.= "Reply-To: noreply@SistemaEgresados.com"."\r\n";
    $header.= "X-Mailer: PHP/".phpversion();

    /*  Enviamos el Correo */
    @mail($email, $issue, $mailMessage, $header);
  }

  /* Funcion para obtener el primer elemento de una busqueda */
  function getFirstQueryElement($conn, $table, $item, $coincidence, $keyCoincidence)
  {
    $query = "SELECT '".$item."' FROM '".$table."' WHERE '".$coincidence."'='".$keyCoincidence."'";
    $res = mysqli_query($conn, $query);
    $res-> fetch_array($res);

    return $res[0];
  }

?>
