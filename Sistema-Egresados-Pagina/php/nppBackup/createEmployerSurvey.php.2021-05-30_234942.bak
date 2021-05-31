<?php
require_once "dbh.php";

/*
 * Recibe:
 *      surveyName
 *      idAdmin_Master
 * Retorna:
 *      Entero positivo correspondiente al ID
 *      Entero negativo en caso de error
 */

if(isset($_POST['surveyName']))
    $surveyName = $_POST['surveyName'];
else
    die('Se requiere nombre de encuesta');

if(isset($_POST['idAdmin_Master']))
    $idUniversidad = $_POST['idUniversidad'];
else
	die('No se mando el id de Admin_Master');

$sql = "INSERT INTO Encuesta (Nombre) VALUES ({$surveyName})";

if(isset($sql)) {
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    echo $row['RESULT'];
    
}

$conn->close();
?>