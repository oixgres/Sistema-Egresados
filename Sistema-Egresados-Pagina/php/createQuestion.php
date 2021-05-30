<?php
require_once "dbh.php";

/*
 * Recibe:
 *      surveyId
 *      titulo
 *      tipo
 *      tema
 * Retorna:
 *      questionId / errorCode
 */

$surveyId = $_POST['surveyId'];
$title = $_POST['title'];
$type = $_POST['type'];
$theme = $_POST['theme'];

$sql = "INSERT INTO Pregunta (Encuesta_idEncuesta, Pregunta, Tipo, Tema) VALUES ('".$surveyId."', '".$title."', '".$type."', '".$theme."')";
if(mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo -1;
}

$conn->close();