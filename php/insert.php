<?php
require_once 'dbh.php';

if($conn)
{
  $name = $_POST['idName'];
  $lastname = $_POST['idLastName'];
  $matricula = $_POST['idMat'];
  $email = $_POST['idMail'];
  $password = $_POST['idPass'];
  $password2 = $_post['idPass2'];

  $checkmail = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$email."'");

  if($checkmail)
  {
    echo "Correo ya existente";
  }
  else
  {
      if($password != $password)
      {
        echo "Error en Contraseña";
      }
      else
      {
          mysqli_query($conn, "INSERT INTO Usuario (Correo, Password, Nombres, Apellidos, Matricula) VALUES ('$email','$password','$name','$lastname','$matricula')");
          header("Location: ../html/regSucessful.html");
      }
  }
}
else
{
  echo "No se pudo conectar con la base de datos";
}

?>
