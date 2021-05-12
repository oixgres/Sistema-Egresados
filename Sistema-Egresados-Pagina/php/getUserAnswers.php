<?php
require_once "dbh.php";
/*	
 * Recibe:
 *	idEncuesta : INT
 *	idUsuario : INT
 *
 * Devuelve:
 *	Todas las preguntas de la encuesta y las respuestas del
 *	usuario por cada pregunta.
 *
 *	(JSON)
 *	Pregunta : VARCHAR(200)
 *	Respuesta : VARCHAR(45)
 *
 *	Codigos de error:
 *	-1 : Alguno de los datos no se envio correctamente
 *	-2 : No existe la encuesta
 *  -3 : El usuario no ha respondido la encuesta
 *	-4 : La encuesta no contiene preguntas
 *
*/

//Confirmacion de envio de datos

if(isset($_POST['idEncuesta'])) {
	$idEncuesta = $_POST['idEncuesta'];
} else {
	echo -1;
  	$conn->close();
  	exit();
}

if(isset($_POST['idUsuario'])) {
	$idUsuario = $_POST['idUsuario'];
} else {
	echo -1;
  	$conn->close();
  	exit();
}

//Si la encuesta existe...

$sql = "SELECT * FROM encuesta WHERE idEncuesta = ${idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
  	echo -2;
  	$conn->close();
  	exit();
}

//Si la encuesta está contestada...

$sql = "SELECT * FROM encuestas_contestadas 
		WHERE Encuesta_idEncuesta = ${idEncuesta} 
		AND Usuario_idUsuario = ${idUsuario}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
  	echo -3;
  	$conn->close();
  	exit();
}

//Verificamos que haya preguntas en la encuesta...

$sql = "SELECT Pregunta FROM pregunta
		WHERE Encuesta_idEncuesta = ${idEncuesta}
		ORDER BY idPregunta"
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
  	echo -4;
  	$conn->close();
  	exit();
}

//Obtenemos todas las respuestas del usuario...

$sql = "SELECT pregunta.Pregunta, respuesta_usuario.Respuesta FROM respuesta_usuario
		INNER JOIN pregunta ON pregunta.idPregunta = respuesta_usuario.Pregunta_idPregunta
		INNER JOIN encuesta ON encuesta.idEncuesta = pregunta.Encuesta_idEncuesta
		WHERE encuesta.idEncuesta = ${idEncuesta}
		ORDER BY pregunta.idPregunta"
$respuestas_usuario = mysqli_query($conn, $sql);

if($respuestas_usuario->num_rows == 0) {
  	echo -3;
  	$conn->close();
  	exit();
}

//Se hace el JSON

$json = array();

while($fila = mysqli_fetch_array($respuestas_usuario)) {
  $json [] = $fila;
}

//Se envia el JSON si no está vacio.

if(!empty($json)) 
{
	$jsonString = json_encode($json); 	//convertir el json a cadena
	echo $jsonString; 					//retornar el json al frontend
} else {
 	echo -3; 
}

$conn->close();
?>