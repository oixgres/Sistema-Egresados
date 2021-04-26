<?php
  /* Funcion para generar claves */
  function generateCode($conn, $id, $action)
  {
    /* Si la clave no es nueva borramos la existente */
    if($action == "again")
    {
      mysqli_query($conn, "DELETE FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$id."'");
    }

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
    $query = "SELECT $item FROM $table WHERE $coincidence='".$keyCoincidence."'";
    $res = mysqli_query($conn, $query);
    $res = $res->fetch_array();
    return $res[0];
  }

  function checkSession($userType)
  {
    session_start();

    /* Si la cookie y session no coinciden o si no existe session*/
    if($_COOKIE["token"] != $_SESSION["token"] || !isset($_SESSION['token']))
    {
      header("Location: ../index.html");
      exit();
    }
    else
      /* Si el tipo de usuario no coincide */
      if($_COOKIE["userType"] != $userType)
      {
        header("Location: ../html/denied.html");
        exit();
      }
  }

  function createToken()
  {
    return sha1(uniqid(rand(10000000,99999999), true));
  }

  function setUserCookies($token, $idUser, $name, $lastname, $mail, $userType)
  {
    /* Creamos una cookie para almacenar el token del lado del egresado */
    setcookie("token",$token,time()+(60*60*24*30), "/");

    /* Creamos cookie para almacenar el nombre de egresado */
    setcookie("name", getFirstQueryElement($conn, "Usuario", "Nombres", "Correo", $mail), time()+(60*60*24*30),"/");

    /* Creamos cookie para almacenar los apellidos del egresado */
    setcookie("lastname", getFirstQueryElement($conn, "Usuario", "Apellidos", "Correo", $mail), time()+(60*60*24*30),"/");

    /* Creamos cookie para almacenar el correo del egresado */
    setcookie("mail", $mail, time()+(60*60*24*30),"/");

    /* Creamps cookie para el id del usuario */
    setcookie("id",  $idUser, time()+(60*60*24*30),"/");

    setcookie("userType", $userType, time()+(60*60*24*30),"/");
  }

?>
