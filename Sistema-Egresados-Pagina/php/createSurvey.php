<?php
require_once "dbh.php";

/*
 * Recibe:
 *      surveyName
 *      university
 *      campus
 *      faculty
 *      program
 * Retorna:
 *      surveyId / errorCode
 */

$university = $_POST['university'];
$campus = $_POST['campus'];
$faculty = $_POST['faculty'];
$program = $_POST['program'];
$surveyName = $_POST['surveyName'];

if(isset($university)) {
    $sql = "SELECT idUniversidad FROM Universidad WHERE Nombre = '$university'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['idUniversidad'];

    $sql = "INSERT INTO Encuesta (Nombre, Universidad_idUniversidad) VALUES ('$surveyName', '$id')";
} else if(isset($campus)) {
    $sql = "SELECT idCampus FROM Campus WHERE Nombre = '$campus'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['idCampus'];

    $sql = "INSERT INTO Encuesta (Nombre, Campus_idCampus) VALUES ('$surveyName', '$id')";
} else if(isset($faculty)) {
    $sql = "SELECT idFacultad FROM Facultad WHERE Nombre = '$faculty'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['idFacultad'];

    $sql = "INSERT INTO Encuesta (Nombre, Facultad_idFacultad) VALUES ('$surveyName', '$id')";
} else if(isset($program)) {
    $sql = "SELECT idPlan_Estudio FROM Plan_Estudio WHERE Nombre = '$program'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['idPlan_Estudio'];

    $sql = "INSERT INTO Encuesta (Nombre, Plan_Estudio_idPlan_Estudio) VALUES ('$surveyName', '$id')";
} else {
    echo "error: ningun alcance seleccionado";
}

if(mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo "error: no se pudo crear encuesta";
}

$conn->close();