<?php

session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

$idUser = $_SESSION['idUser'];

if(isset($_GET['newKey']))
{

  $email = getFirstQueryElement($conn, 'Usuario', 'Correo', 'idUsuario', $idUser);

  /* Creamos y enviamos correo */
  $key = generateCode($conn, $idUser, "again");
  sendCode($conn, $email, "Nuevo Codigo de Verificación", $key);
}
else
{
  if(isset($_POST['key']))
  {
    $key = getFirstQueryElement($conn, "Claves_Confirmacion", "Clave", "Usuario_idUsuario", $idUser);

    $insertedKey = $_POST['key'];

    if($key == $insertedKey)
    {
      /* Activamos al Usuario */
      mysqli_query($conn, "UPDATE Usuario SET Estatus='ACTIVO' WHERE idUsuario='".$idUser."'");

      /* Eliminamos el codigo */
      mysqli_query($conn, "DELETE FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$idUser."'");

      header("Location: ../html/profile.html");
      exit();
    }
    else
    {
        echo "Las claves no coinciden";
    }
  }
}
?>
