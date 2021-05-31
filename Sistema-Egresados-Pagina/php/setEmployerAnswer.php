<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idPregunta : INT
 * 	idEmpleador : INT
 * 	respuesta : VARCHAR(45)
 *
 * Devuelve:
 * 	Llave primaria insertada
 *
 *  Códigos de error:
 *  -1 : No se mandó el idPregunta, idEmpleador o respuesta
 *  -2 : No existe pregunta o empleador
 *  -3 : Error al insertar
*/



if (!isset($_POST['idPregunta']) || !isset($_POST['idEmpleador']) || !isset($_POST['respuesta'])) {
    echo -1;
    $conn->close();
    exit();
} else {
    $idPregunta = $_POST['idPregunta'];
    $idEmpleador = $_POST['idEmpleador'];
    $respuesta = $_POST['respuesta'];
}

$sqlQuestion = "SELECT idPregunta FROM Pregunta WHERE idPregunta = '$idPregunta'";
$sqlEmpleador = "SELECT idEmpleador FROM Empleador WHERE idEmpleador = '$idEmpleador'";
$resQuestion = mysqli_query($conn, $sqlQuestion);
$resEmpleador = mysqli_query($conn, $sqlEmpleador);

if ($resQuestion->num_rows == 0 || $resEmpleador->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "INSERT INTO Respuesta_Empleador(Respuesta, Pregunta_idPregunta, Empleador_idEmpleador)
        VALUES ('$respuesta', '$idPregunta', '$idEmpleador')";
if (mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo mysqli_error($conn);
}

$conn->close();

?>