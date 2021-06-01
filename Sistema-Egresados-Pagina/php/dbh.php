<?php

$dbServername = 'localhost';
$dbUsername = 'conisoft_SE';
$dbPassword = 'Portal071198';
$dbName = 'conisoft_Sistema-Egresados';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Habilita caracteres con acento para busquedas.
$conn->set_charset("utf8");
?>