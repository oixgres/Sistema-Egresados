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

  header("Location: ../html/verificationPage.html");
  exit();
}
else
  /* Comparar claves */
  if(isset($_POST['key']))
  {
    $key = getFirstQueryElement($conn, "Claves_Confirmacion", "Clave", "Usuario_idUsuario", $idUser);

    $insertedKey = $_POST['key'];

    if($key == $insertedKey)
    {
      /* Eliminamos cookie de verificacion*/
      setcookie("verification", "",time()-1,"/");
      setcookie("userType", "",time()-1,"/");

      /* Eliminamos el codigo */
      mysqli_query($conn, "DELETE FROM Claves_Confirmacion WHERE Usuario_idUsuario='".$idUser."'");

      /* Creamos token, cookies y session */
      $name = getFirstQueryElement($conn, "Usuario", "Nombres", "idUsuario", $idUser);
      $lastname = getFirstQueryElement($conn, "Usuario", "Apellidos", "idUsuario", $idUser);
      $email = getFirstQueryElement($conn, 'Usuario', 'Correo', 'idUsuario', $idUser);

      $token = createToken();
      $_SESSION['token'] = $token;

      setUserCookies($token, $idUser, $name, $lastname, $email, "user");

      header("Location: profile.php");
      exit();
    }
    else
    {
        echo "Las claves no coinciden";
    }
  }
?>
