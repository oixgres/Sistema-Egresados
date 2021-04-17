<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idPregunta : INT
 * 	idUsuario : INT
 * 	respuesta : VARCHAR(45)
 *
 * Devuelve:
 * 	Llave primaria insertada
 *
 *  Códigos de error:
 *  -1 : No se mandó el idPregunta, idUsuario o respuesta
 *  -2 : No existe pregunta o usuario
 *  -3 : Error al insertar
*/

if (!isset($_POST['idPregunta']) || !isset($_POST['idUsuario']) || !isset($_POST['respuesta'])) {
    echo -1;
    $conn->close();
    exit();
} else {
    $idPregunta = $_POST['idPregunta'];
    $idUsuario = $_POST['idUsuario'];
    $respuesta = $_POST['respuesta'];
}

$sqlQuestion = "SELECT idPregunta FROM Pregunta WHERE idPregunta = '$idPregunta'";
$sqlUser = "SELECT idUsuario FROM Usuario WHERE idUsuario = '$idUsuario'";
$resQuestion = mysqli_query($conn, $sqlQuestion);
$resUser = mysqli_query($conn, $sqlUser);

if ($resQuestion->num_rows == 0 || $resUser->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "INSERT INTO Respuesta_Usuario(Respuesta, Pregunta_idPregunta, Usuario_idUsuario)
        VALUES ('$respuesta', $idPregunta, $idUsuario)";
if (mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo -3;
}

$conn->close();