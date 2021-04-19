 <?php
session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

$mail = $_POST['username'];
$pass = $_POST['password'];


/*Login de Egresado*/
/* Checamos que exista el usuario egresado y que  este activo */
$res = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$mail."' AND Password='".$pass."'");
$nr = mysqli_num_rows($res);

/* Si existe */
if($nr == 1)
{
  $idUser = getFirstQueryElement($conn, "Usuario", "idUsuario", "Correo", $mail);
  $query = "SELECT * FROM Usuario WHERE Correo='".$mail."' AND Password='".$pass."' AND Estatus='INACTIVO'";

  /* si  no esta activo la cuenta */
  if(mysqli_query($conn, $query))
  {
    $_SESSION['idUser'] = $idUser;
    header("Location: ../html/verificationPage.html");
    exit();
  }
  else
  {
    /* Creamos un token para almacenarlo en cookies */
    $token = sha1(uniqid(rand(10000000,99999999), true));

    /* Guardamos el token en el servidor */
    $_SESSION['token'] = $token;

    /* Creamos una cookie para almacenar el token del lado del egresado */
    setcookie("token",$token,time()+(60*60*24*30), "/");

    /* Creamos cookie para almacenar el nombre de egresado */
    setcookie("name", getFirstQueryElement($conn, "Usuario", "Nombres", "Correo", $mail), time()+(60*60*24*30),"/");

    /* Creamos cookie para almacenar los apellidos del egresado */
    setcookie("lastname", getFirstQueryElement($conn, "Usuario", "Apellidos", "Correo", $mail), time()+(60*60*24*30),"/");

    /* Creamos cookie para almacenar el correo del egresado */
    setcookie("mail", $mail, time()+(60*60*24*30),"/");

    /* Creamps cookie para el id del usuario */
    setcookie("id",  $idUser, time()+(60*60*24*30),"/");

    header("Location: profile.php");
    exit();
  }

}
else
  echo "Ha ocurrido un error, contacte con el administrador"; //si no existe
?>
