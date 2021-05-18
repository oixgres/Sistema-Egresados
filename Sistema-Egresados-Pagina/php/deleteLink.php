<?php 

require_once 'dbh.php';

$id = $_POST['id'];

$query = "DELETE FROM Enlaces_Usuario WHERE idEnlaces_Usuario='".$id."'";
mysqli_query($conn, $query);

mysqli_close($conn);

?>