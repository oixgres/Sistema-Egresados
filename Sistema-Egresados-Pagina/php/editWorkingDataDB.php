<?php 

require_once 'dbh.php';
require_once 'generalFunctions.php';

$date = $_POST['fecha'];
$job = $_POST['empleo'];
$company = $_POST['empresa'];
$pos = $_POST['puesto'];
$category = $_POST['categoria'];
$email = $_POST['correo'];
$dep = $_POST['departamento'];
$tec = $_POST['tecnologias'];
$act = $_POST['actividades'];

$action = $_POST['action'];

switch($action)
{
  case 'edit':
    $query = "UPDATE Datos_Laborales SET Inicio='$date', Empleo='$job', Empresa='$company', Puesto='$pos', Categoria='$category', Correo_Emp='$email', Departamento='$dep', Tecnologias='$tec', Actividades='$act' WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    mysqli_query($conn, $query);
  break;

  case 'change':
    $work = getFirstQueryElement($conn, 'Datos_Laborales','Labora', 'Usuario_idUsuario', $_COOKIE['id']);
    $id = getFirstQueryElement($conn, 'Datos_Laborales', 'idDatos_Laborales', 'Usuario_idUsuario', $_COOKIE['id']);

    if($work == 0)
    {
      $query = "DELETE FROM Historial_Laboral WHERE Datos_Laborales_idDatos_Laborales='$id'";
      mysqli_query($conn, $query);
    }

    $query = "DELETE FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    mysqli_query($conn, $query);

    $query = "INSERT INTO Datos_Laborales (Usuario_idUsuario, Labora, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades, Inicio) VALUES ('".$_COOKIE['id']."', 1, '$job', '$company', '$pos', '$category', '$email', '$dep', '$tec', '$act', '$date')";
    mysqli_query($conn, $query);
  break;

  case 'editHistory':
    $query = "UPDATE Historial_Laboral SET Inicio='$date', Empleo='$job', Empresa='$company', Puesto='$pos', Categoria='$category', Correo_Emp='$email', Departamento='$dep', Tecnologias='$tec', Actividades='$act' WHERE idHistorial_Laboral='".$_COOKIE['historial']."'";
    mysqli_query($conn, $query);

    setcookie("historial", "",time()-1,"/");
  break;

  case 'addHistory':
    $query = "INSERT INTO Historial_Laboral (Usuario_idUsuario, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades, Inicio) VALUES ('".$_COOKIE['id']."', '$job', '$company', '$pos', '$category', '$email', '$dep', '$tec', '$act', '$date')";
    mysqli_query($conn, $query);
  break;
}

mysqli_close($conn);

header('Location: profile.php');
exit();
?>
