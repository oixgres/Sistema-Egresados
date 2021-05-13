<?php

require_once 'dbh.php';

$id = $_POST['id'];
$name = $_POST['name'];
$link = $_POST['link'];

if(!empty($id))
{
    $query = "UPDATE Enlaces_Usuario SET Nombre='".$name."', Link='".$link."' WHERE idEnlaces_Usuario='".$id."'";
    mysqli_query($conn,$query);
    echo "actualizado";
}
else
{
    $query = "INSERT INTO Enlaces_Usuario (Nombre, Link, Usuario_idUsuario) VALUES('".$name."', '".$link."', '".$_COOKIE['id']."')";
    mysqli_query($conn, $query);
    echo mysqli_insert_id($conn);
}

mysqli_close($conn);
?>