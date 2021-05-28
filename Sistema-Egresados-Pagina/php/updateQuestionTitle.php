<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idPregunta : INT
 *	pregunta   : VARCHAR(200)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idPregunta o pregunta
 *  -2 : No existe el idPregunta en la base de datos
 *	-3 : Error en la consulta
*/

if(isset($_POST['idPregunta']) && isset($_POST['pregunta'])) {
    $idPregunta = $_POST['idPregunta'];
    $pregunta = $_POST['pregunta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idPregunta FROM Pregunta WHERE idPregunta = ${idPregunta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "UPDATE Pregunta SET Pregunta.Pregunta = '${pregunta}' WHERE idPregunta = ${idPregunta}";
if(mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();