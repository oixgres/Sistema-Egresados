 <?php
session_start();
//https://www.youtube.com/watch?v=3Gkx_8wU9Hw&ab_channel=ErickVladimirReyesMar%C3%ADnhttps://www.youtube.com/watch?v=3Gkx_8wU9Hw&ab_channel=ErickVladimirReyesMar%C3%ADn
// Cerrar sesion 40:00

require_once 'dbh.php';
require_once 'generalFunctions.php';

$mail = $_POST['userInput'];
$pass = $_POST['passwordInput'];

/* Checamos que exista el usuario y este activo */
$res = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$mail."' AND Password='".$pass."'");
$nr = mysqli_num_rows($res);

/* Si existe */
if($nr == 1)
{
  /* Creamos un token para almacenarlo en cookies */
  $token = sha1(uniqid(rand(10000000,99999999), true));

  /* Guardamos el token en el servidor */
  $_SESSION['token'] = $token;

  /* Creamos una cookie para almacenar el token del lado del cliente*/
  setcookie("token",$token,time()+(60*60*24*30), "/");
  /* Creamos cookie para almacenar el nombre de cliente*/
  setcookie("name", getFirstQueryElement($conn, "Usuario", "Nombre", "Correo", $mail));

  header("Location: pruebas.php");
}
else
  echo "Ha ocurrido un error, contacte con el administrador"; //si no existe



?>
