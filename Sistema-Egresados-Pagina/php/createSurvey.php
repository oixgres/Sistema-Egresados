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

if(isset($_POST['university']))
    $university = $_POST['university'];

if(isset($_POST['campus']))
    $campus = $_POST['campus'];

if(isset($_POST['faculty']))
    $faculty = $_POST['faculty'];

if(isset($_POST['program']))
    $program = $_POST['program'];

if(isset($_POST['surveyName']))
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
    die('No has seleccionado ningun alcance');
}

if(isset($sql) && mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    die("no se pudo crear encuesta");
}

$conn->close();