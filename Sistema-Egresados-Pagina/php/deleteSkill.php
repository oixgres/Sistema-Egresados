<?php 

require_once 'dbh.php';

$id = $_POST['id'];

$query = "DELETE FROM Habilidades_Usuario WHERE idHabilidades_Usuario='".$id."'";
mysqli_query($conn, $query);
echo "Listo";

mysqli_close($conn);

?>