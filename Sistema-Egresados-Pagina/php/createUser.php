<?php
session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

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
        /*
        $idUser = mysqli_query($conn, "SELECT idUsuario FROM Usuario WHERE Correo='".$email."'");
        $idUser = $idUser->fetch_array();
        $idUser = intval($idUser[0]);
        */

        /* Obtenemos el ID del Usuario */
        $idUser = getFirstQueryElement($conn, "Usuario", "idUsuario", "Correo", $email);

        /* Creamos y enviamos correo */
        $key = generateCode($conn, $idUser, "new");
        sendCode($conn, $email, "Codigo de Verificación", $key);

        /* Nos servira para verificar al usuario */
        $_SESSION['idUser'] = $idUser;

        mysqli_close($conn);
        header("Location: verificationPage.php");
        exit();
      }
  }
}
else
{
  echo "No se pudo conectar con la base de datos";
}

?>
