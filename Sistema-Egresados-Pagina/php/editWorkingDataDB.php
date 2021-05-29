<?php 

require_once 'dbh.php';

$date = $_POST['fecha'];
$job = $_POST['empleo'];
$company = $_POST['empresa'];
$pos = $_POST['puesto'];
$category = $_POST['categoria'];
$email = $_POST['correo'];
$dep = $_POST['departamento'];
$tec = $_POST['tecnologias'];
$act = $_POST['actividades'];

$query = "UPDATE Datos_Laborales SET Inicio='$date', Empleo='$job', Empresa='$company', Puesto='$pos', Categoria='$category', Correo_Emp='$email', Departamento='$dep', Tecnologias='$tec', Actividades='$act' WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
mysqli_query($conn, $query);

mysqli_close($conn);

header('Location: profile.php');
exit();
?>
