<?php 

require_once 'dbh.php';

$query = "UPDATE Usuario SET Actualizaciones=3 WHERE Actualizaciones < 3";
mysqli_query($conn, $query);

mysqli_close($conn);

?>