<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *
 * Devuelve:
 * 	0 ; Operacion exitosa
 *
 *  Códigos de error:
 *  -1 : No se enviaron correctamente los datos.
 *  -2 : No hay una encuesta con esa ID en la tabla encuesta.
 *  -3 : No se ha podido eliminar las respuestas_usuario.
 *  -4 : No se pudo eliminar las respuestas de las preguntas.
 *  -5 : No se han podido borrar las preguntas de la encuesta.
*/

if (!isset($_POST['idEncuesta'])){
    echo -1;
    $conn->close();
    exit();
}

$idEncuesta = $_POST['idEncuesta'];

//Se verifica que exista la encuesta dado el ID recibido.

$sql = "SELECT idEncuesta FROM Encuesta WHERE idEncuesta = {$idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0)
{
	echo -2;
    $conn->close();
    exit();
}

//Se borran los campos de respuesta_usuario que coincidan con las
// respuestas de las preguntas de la encuesta.

$sql = "DELETE Respuesta_Usuario FROM Respuesta_Usuario
		INNER JOIN Pregunta ON Respuesta_Usuario.Pregunta_idPregunta = Pregunta.idPregunta
		WHERE Pregunta.Encuesta_idEncuesta={$idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res == false)
{
	echo -3;
    $conn->close();
    exit();
}

//Se borran los campos de respuesta que coincidan con las
// las preguntas de la encuesta.

$sql = "DELETE Respuesta FROM Respuesta
		INNER JOIN Pregunta ON Respuesta.Pregunta_idPregunta = Pregunta.idPregunta
		WHERE Pregunta.Encuesta_idEncuesta={$idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res == false)
{
	echo -4;
    $conn->close();
    exit();
}

//Se borran los campos de pregunta para la encuesta.

$sql = "DELETE FROM Pregunta
		WHERE Pregunta.Encuesta_idEncuesta={$idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res == false)
{
	echo -5;
    $conn->close();
    exit();
}

//Se devuelve 0 como codigo de operacion exitosa.

echo 0;

?>