<?php

require_once 'dbh.php';

$id = $_POST['id'];
$skill = $_POST['skill'];

if(!empty($id))
{
    $query = "UPDATE Habilidades_Usuario SET Texto='".$skill."' WHERE idHabilidades_Usuario='".$id."'";
    mysqli_query($conn,$query);
    
    //$res = json_encode([$id, $name, $link]);
    $res = array('type' => "mod", 'id' => $id, 'skill' => $skill);

    echo json_encode($res);
}
else
{
    $query = "INSERT INTO Habilidades_Usuario (Texto, Usuario_idUsuario) VALUES('".$skill."', '".$_COOKIE['id']."')";
    mysqli_query($conn, $query);

    $res = array('type' => "new", 'id' => mysqli_insert_id($conn));
    
    echo json_encode($res);
}

mysqli_close($conn);
?>