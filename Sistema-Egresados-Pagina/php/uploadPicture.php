<?php 

require_once 'dbh.php';
require_once 'generalFunctions.php';

$targetDir = '../img/Profile/';
$targetImg = $targetDir.basename($_FILES['file']['name']);
$imageFileType = strtolower(pathinfo($targetImg, PATHINFO_EXTENSION));

$uploadReady = 1;

/* Se presiona el boton */
if(isset($_POST['submit']))
{
  /* Se verifica que si sea una imagen */
  $verify = getimagesize($_FILES['file']['name']);

  if($verify === false || file_exists($targetImg) || !allowedImageTypes($imageFileType))
      $uploadReady = 0;
}

if($uploadReady == 0){
  echo "error";
}
else
{
  /* Obtenemos la imagen anterior en el servidor */
  $query = "SELECT * FROM Foto_Perfil WHERE Usuario_idUsuario='".$_COOKIE['id']."'";

  /* Eliminamos la imagen anterior del servidor */
  $res = mysqli_query($conn, $query);
  $res = mysqli_fetch_assoc($res);
  unlink($res['Direccion']);

  /* Asignamos la nueva imagen al usuario */ 
  $query = "UPDATE Foto_Perfil SET Direccion='$targetImg' WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
  mysqli_query($conn, $query);
  move_uploaded_file($_FILES['file']['tmp_name'], $targetImg);

  /* Cerramos la conexion */
  mysqli_close($conn);

  header("Location: profile.php");
  exit();
}


?>