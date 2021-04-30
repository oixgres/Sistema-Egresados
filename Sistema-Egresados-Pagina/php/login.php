 <?php
session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

$mail = $_POST['username'];
$pass = $_POST['password'];
$typeLogin = $_POST['radioButton'];

/*Login de Egresado*/
if($typeLogin == "asUser")
{
  /* Checamos que exista el usuario egresado y que  este activo */
  $res = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$mail."' AND Password='".$pass."'");
  $nr = mysqli_num_rows($res);

  /* Si existe el usuario */
  if($nr == 1)
  {
    $idUser = getFirstQueryElement($conn, "Usuario", "idUsuario", "Correo", $mail);
    $status = getFirstQueryElement($conn, "Usuario", "Estatus", "Correo", $mail);
    $name = getFirstQueryElement($conn, "Usuario", "Nombres", "Correo", $mail);
    $lastname = getFirstQueryElement($conn, "Usuario", "Apellidos", "Correo", $mail);

    /* si no esta activa la cuenta */
    if($status == "INACTIVO")
    {
      setcookie("verification", $idUser,time()+(60*60*24*30),"/");
      setcookie("userType", "new",time()+(60*60*24*30),"/");
      header("Location: ../html/verificationPage.html");
      exit();
    }
    else
    {
      /* Creamos un token para almacenarlo en cookies */
      $token = createToken();

      /* Guardamos el token en el servidor */
      $_SESSION['token'] = $token;

      setUserCookies($token, $idUser, $name, $lastname, $mail, "user");

      header("Location: profile.php");
      exit();
    }
  }
  /* Si no existe el admin */
  else
    echo "Usuario o Contraseña incorrectos";
}
else
  if($typeLogin == "asAdmin")
  {
    /* checamos que exista un administrador */
    $res = mysqli_query($conn, "SELECT * FROM Admin WHERE Correo='".$mail."' AND Password='".$pass."'");
    $nr = mysqli_num_rows($res);

    /* Si existe continuamos */
    if($nr == 1)
    {
      /* Obtenemos datos para almacenar en la cookie */
      $idUser = getFirstQueryElement($conn, "Admin", "idAdmin", "Correo", $mail);
      $name = getFirstQueryElement($conn, "Admin", "Nombres", "Correo", $mail);
      $lastname = getFirstQueryElement($conn, "Admin", "Apellidos", "Correo", $mail);

      /* Creamos un token para almacenarlo en cookies */
      $token = createToken();

      /* Guardamos el token en el servidor */
      $_SESSION['token'] = $token;

      setUserCookies($token, $idUser, $name, $lastname, $mail, "admin");

      header("Location: menu.php");
      exit();

    }
    /* Si no existe terminamos */
    else
    {
      echo "Usuario o Contraseña incorrectos";
    }
  }
  else
    echo "Ha ocurrido un error, contacte con el administrador"; //si no existe
?>
