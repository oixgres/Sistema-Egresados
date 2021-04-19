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
 *      Entero positivo correspondiente al ID
 *      Entero negativo en caso de error
 */

if(isset($_POST['surveyName']))
    $surveyName = $_POST['surveyName'];
else
    die('Se requiere nombre de encuesta');

if(isset($_POST['university']) && $_POST['university'] !== "NULL")
    $university = $_POST['university'];

if(isset($_POST['campus']) && $_POST['campus'] !== "NULL")
    $campus = $_POST['campus'];

if(isset($_POST['faculty']) && $_POST['faculty'] !== "NULL")
    $faculty = $_POST['faculty'];

if(isset($_POST['program']) && $_POST['program'] !== "NULL")
    $program = $_POST['program'];


if(isset($university)) {
    $sql = "CALL insertSurvey('$surveyName', '$university', 0)";
} else if(isset($campus)) {
    $sql = "CALL insertSurvey('$surveyName', '$campus', 1)";
} else if(isset($faculty)) {
    $sql = "CALL insertSurvey('$surveyName', '$faculty', 2)";
} else if(isset($program)) {
    $sql = "CALL insertSurvey('$surveyName', '$program', 3)";
} else {
    die('No has seleccionado ningun alcance');
}

if(isset($sql)) {
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    echo $row['RESULT'];
}

$conn->close();