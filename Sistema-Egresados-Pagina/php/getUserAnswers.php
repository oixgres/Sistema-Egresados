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
 *	pregunta   : VARCHAR(200)
 *	respuestas : VARCHAR(200)
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

$sql = "SELECT * FROM Encuesta WHERE idEncuesta = '$idEncuesta'";
$res = mysqli_query($conn, $sql);


if($res->num_rows == 0) {
  	echo -2;
  	$conn->close();
  	exit();
}

//Si la encuesta está contestada...

$sql = "SELECT * FROM Encuestas_Contestadas 
		WHERE Encuesta_idEncuesta = '$idEncuesta' 
		AND Usuario_idUsuario = '$idUsuario'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
  	echo -3;
  	$conn->close();
  	exit();
}

//Verificamos que haya preguntas en la encuesta...

$sql = "SELECT Pregunta FROM Pregunta
		WHERE Encuesta_idEncuesta = ${idEncuesta}
		ORDER BY idPregunta";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
  	echo -4;
  	$conn->close();
  	exit();
}

//Obtenemos todas las respuestas del usuario...

$sql = "SELECT Pregunta.idPregunta, Pregunta.Pregunta, Respuesta_Usuario.Respuesta FROM Respuesta_Usuario
		INNER JOIN Pregunta ON Pregunta.idPregunta = Respuesta_Usuario.Pregunta_idPregunta
		INNER JOIN Encuesta ON Encuesta.idEncuesta = Pregunta.Encuesta_idEncuesta
		WHERE Encuesta.idEncuesta = ${idEncuesta}
		ORDER BY Pregunta.idPregunta";
$respuestas_usuario = mysqli_query($conn, $sql);

if($respuestas_usuario->num_rows == 0) {
  	echo -3;
  	$conn->close();
  	exit();
}

//Se hace el JSON

$json = array();

while($fila = mysqli_fetch_array($respuestas_usuario)) {
    if (!array_key_exists($fila['idPregunta'], $json)) {
        $preguntas = array(
            'pregunta' => $fila['Pregunta'],
            'respuestas' => $fila['Respuesta']."<br>"
        );
        $json[$fila['idPregunta']] = $preguntas;
    } else {
        $json[$fila['idPregunta']]['respuestas'] .= $fila['Respuesta']."<br>";
    }
}
/*  JSON Ejemplo:
 *  string(250) "{"1":{"pregunta":"Cuanto tiempo tardaste en encontrar trabajo?","respuestas":"6 meses<br>"},
 *                "2":{"pregunta":"En que area se especializa tu empresa?","respuestas":"Sistemas<br>Electronica<br>"},
 *                "3":{"pregunta":"Cuanto ganas?","respuestas":"6000<br>"}}"
 *  Se envia el JSON si no está vacio.
*/
if(!empty($json)) 
{
	$jsonString = json_encode($json); 	//convertir el json a cadena
	echo $jsonString; 					//retornar el json al frontend
} else {
 	echo -3; 
}

$conn->close();