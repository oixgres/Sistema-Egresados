<?php

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

        /* Obtenemos el ID del Usuario */
        $idUser = getFirstQueryElement($conn, "Usuario", "idUsuario", "Correo", $email);

        /* Creamos y enviamos correo */
        $key = generateCode($conn, $idUser, "new");
        sendCode($conn, $email, "Codigo de Verificación", $key);

        /* Nos servira para verificar al usuario */
        //$_SESSION['idUser'] = $idUser;

        /* Creamos cookie de verificacion */
        setcookie("verification", $idUser, time()+(60*60*24*30),"/");
        setcookie("userType", "new",time()+(60*60*24*30),"/");

        mysqli_close($conn);
        header("Location: ../html/verificationPage.html");
        exit();
      }
  }
}
else
{
  echo "No se pudo conectar con la base de datos";
}

?>
