<?php
require_once "dbh.php";

/*
 * Recibe:
 *      questionId
 *      answerText
 * Retorna:
 *      answerId / errorCode
 */

$questionId = $_POST['questionId'];
$answerText = $_POST['answerText'];

$sql = "INSERT INTO Respuesta VALUES ('$questionId', '$answerText');";
if(mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo "error: no se pudo crear respuesta";
}

$conn->close();