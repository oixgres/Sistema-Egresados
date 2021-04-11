<?php
require_once 'dbh.php';

if($conn)
{
  $name = $_POST['idName'];
  $lastname = $_POST['idLastName'];
  $matricula = $_POST['idMat'];
  $email = $_POST['idMail'];
  $password = $_POST['idPass'];
  $password2 = $_POST['idPass2'];


  $checkmail = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$email."'");


  if(mysqli_num_rows($checkmail) > 0)
  {
    echo "Correo ya existente";
  }
  else
  {
      if($password != $password2)
      {
        echo "Error en Contraseña";
      }
      else
      {
        /* Creamos el usuario */
        mysqli_query($conn, "INSERT INTO Usuario (Correo, Password, Nombres, Apellidos, Matricula) VALUES ('$email','$password','$name','$lastname','$matricula')");

        /* Creamos la clave de acceso */
        $key = rand(10000000, 99999999);
        $key = strval($key);

        $idUser = mysqli_query($conn, "SELECT idUsuario FROM Usuario WHERE Correo='".$email."'");
        $idUser = $idUser->fetch_array();
        $idUser = intval($idUser[0]);

        mysqli_query($conn, "INSERT INTO Claves_Confirmacion (Usuario_idUsuario, Clave) VALUES ('$idUser', '$key')");

        /* Mensaje para el correo */
        $mailMessage = "Este es el ultmo paso para crear tu cuenta!"."\r\n";
        $mailMessage.= "Por favor ingresa la siguiente clave en la pagina para finalizar activar tu cuenta"."\r\n";
        $mailMessage.= $key."\r\n\n";
        $mailMessage.= "NOTA: Si usted no creado una cuenta solo ignore el mensaje";



        /* Preparamos el correo */
        $header = "FROM: noreply@SistemaEgresados.com"."\r\n";
        $header.= "Reply-To: noreply@SistemaEgresados.com"."\r\n";
        $header.= "X-Mailer: PHP/".phpversion();

        /*  Enviamos el Correo */
        @mail($email, "Clave de Verificacion", $key, $header);

        header("Location: ../html/regSuccessful.html");
        exit();
      }
  }
}
else
{
  echo "No se pudo conectar con la base de datos";
}

?>
