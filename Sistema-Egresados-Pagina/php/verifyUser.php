<?php
session_start();

require_once 'dbh.php';
require_once 'generalFunctions.php';

$idUser = $_SESSION['idUser'];

echo $idUser;

?>
