
<?php
/*
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "harry1234";
$dbName = "sistemaegresados";
*/


/*
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "harry6627";
$dbName = "sistemaegresados";
*/

/* Servidor Actual */
/*
$dbServername = "localhost";
$dbUsername = "omdprofx_guerra-c";
$dbPassword = "Gue1870";
$dbName = "omdprofx_guerra-c-ordinario";
*/

/*
$dbServername = "localhost";
$dbUsername = "omdprofx_omarmontoya";
$dbPassword = "Oma46012";
$dbName = "omdprofx_omarmontoya-proyecto";
*/

/* Servidor de Reyes */
$dbServername = 'localhost';
$dbUsername = 'conisoft_SE';
$dbPassword = 'Portal071198';
$dbName = 'conisoft_Sistema-Egresados';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Habilita caracteres con acento para busquedas.
$conn->set_charset("utf8");
?>