<?php

session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';


$idUser = $_SESSION['idUser'];

if(isset(GET['verifyKey']))
{
  $key = getFirstQueryElement($conn, "Claves_Confirmacion", "Clave", "Usuario_idUsuario", $idUser);

  $insertedKey = $_POST['key'];

  if($key == $insertedKey)
  {
    /* Activamos al Usuario */
    mysqli_query($conn, "UPDATE Usuario SET Estatus='ACTIVO' WHERE idUsuario='".$idUser."'");

    /* Eliminamos el codigo */
    mysqli_query($conn, "DELETE * FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$idUser."'");

    header("Location = ../html/profile.html");
    exit();
  }
  else
  {
      echo "Las claves no coinciden";
  }
}

if(isset(GET['newkey']))
{
  $email = getFirstQueryElement($conn, "Usuario", "Correo", "idUsuario", $idUser);

  /* Creamos y enviamos correo */
  $key = generateCode($conn, $idUser, NULL);
  sendCode($conn, $email, "Nuevo Codigo de Verificación", $key);
}


?>
