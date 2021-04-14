<?php
require_once 'dbh.php';

$mail = $_POST['userInput'];
$pass = $_POST['passwordInput'];

/* Checamos que exista el usuario y este activo */
$res = mysqli_query("SELECT * FROM Usuario WHERE Correo='".$mail."' AND Password='".$pass."'");
$nr = mysqli_num_rows($nr);

if($nr == 1)
{

}
else
  echo "Ha ocurrido un error, contacte con el administrador";



?>
