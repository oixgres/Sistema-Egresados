<?php
require_once "dbh.php";
/* Recibe:
 *	
 * Devuelve:
 *	Todas las encuestas sin alcance (Universales/Para empleadores)
 * 
 *  (JSON)
 *  idEncuesta : INT
 *	Nombre : VARCHAR(45)
 *
 * Errores:
 *	-1 : No hay encuestas
*/

//Se buscan las encuestas

$sql = "SELECT idEncuesta, Nombre FROM Encuesta
		WHERE Universidad_idUniversidad IS NULL
		AND Campus_idCampus IS NULL
		AND Facultad_idFacultad IS NULL
		AND Plan_Estudio_idPlan_Estudio IS NULL";
$res = mysqli_query($conn, $sql);

//Se verifica que la consulta haya devuelto algun valor

if($res->num_rows == 0)
{
	echo -1;
    $conn->close();
    exit();
}

//Se crea el JSON

$json = array();

while($fila = $res->fetch_assoc())
{
	$json [] = $fila;
}

//Se codifica el JSON para ser devuelto.

/*
 *  (JSON)
 *  idEncuesta : INT
 *	Nombre : VARCHAR(45)
*/

$jsonString = json_encode($json); 	//convertir el json a cadena
echo $jsonString; 					//retornar el json al frontend

$conn->close();
?>