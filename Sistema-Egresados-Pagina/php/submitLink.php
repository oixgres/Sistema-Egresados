<?php

require_once 'dbh.php';

$id = $_POST['id'];
$name = $_POST['name'];
$link = $_POST['link'];

$query = "UPDATE Enlaces_Usuario SET Nombre='".$name."', Link='".$link."' WHERE idEnlaces_Usuario='".$id."'";
mysqli_query($conn,$query);

?>