<?php

require_once 'dbh.php';

$id = $_POST['id'];
$name = $_POST['name'];
$link = $_POST['link'];

if(!empty($id))
{
    $query = "UPDATE Enlaces_Usuario SET Nombre='".$name."', Link='".$link."' WHERE idEnlaces_Usuario='".$id."'";
    mysqli_query($conn,$query);
    
    //$res = json_encode([$id, $name, $link]);
    $res = array('type' => "mod", 'id' => $id, 'name' => $name, 'link' => $link);

    echo json_encode($res);
}
else
{
    $query = "INSERT INTO Enlaces_Usuario (Nombre, Link, Usuario_idUsuario) VALUES('".$name."', '".$link."', '".$_COOKIE['id']."')";
    mysqli_query($conn, $query);

    $res = array('type' => "new", 'id' => mysqli_insert_id($conn));
    
    echo json_encode($res);
}

mysqli_close($conn);
?>