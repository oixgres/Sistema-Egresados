<?php
session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

$idUser = $_SESSION['idUser'];

/* Clave nueva */
if(isset($_POST['sendNewCode']))
{
  $email = getFirstQueryElement($conn, 'Usuario', 'Correo', 'idUsuario', $idUser);

  /* Creamos y enviamos correo */
  $key = generateCode($conn, $idUser, "again");
  sendCode($conn, $email, "Nuevo Codigo de Verificación", $key);
}
else
  /* Comparar claves */
  if(isset($_POST['key']))
  {
    $key = getFirstQueryElement($conn, "Claves_Confirmacion", "Clave", "Usuario_idUsuario", $idUser);

    $insertedKey = $_POST['key'];

    if($key == $insertedKey)
    {
      /* Eliminamos el codigo */
      mysqli_query($conn, "DELETE FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$idUser."'");

      header("Location: profile.php");
      exit();
    }
    else
    {
        echo "Las claves no coinciden";
    }
  }
?>
