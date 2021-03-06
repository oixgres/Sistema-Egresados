<?php
require_once "dbh.php";

/*
 * Recibe:
 *      surveyName
 *      idAdmin_Master
 * Retorna:
 *      Entero positivo correspondiente al ID
 *      Entero negativo en caso de error
 *		-1 : No existe el admin master
 */

if(isset($_POST['surveyName']))
    $surveyName = $_POST['surveyName'];
else
    die('Se requiere nombre de encuesta');

if(isset($_POST['idAdmin_Master']))
    $idAdmin_Master = $_POST['idAdmin_Master'];
else
	die('No se mando el id de Admin_Master');

//Se verifica si existe el admin master

$sql = "SELECT idAdmin_Master FROM Admin_Master WHERE idAdmin_Master = {$idAdmin_Master}";
$res = mysqli_query($conn, $sql);

//Si no existe el idAdmin_Master en la base de datos...
if($res->num_rows == 0) 
{
	echo -1;
	$conn->close();
	exit();
}

//Se inserta la encuesta en la tabla Encuesta..

$sql = "INSERT INTO Encuesta (Nombre) VALUES ('$surveyName')";
$res = mysqli_query($conn, $sql);

//No se pudo insertar en la tabla Encuesta

if($res == false)
{
	echo -2;
	$conn->close();
	exit();
}

//Se devuelve el id del ultimo query realizado

$surveyId = mysqli_insert_id($conn);
echo $surveyId;

$conn->close();
?>