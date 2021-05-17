<?php 

require_once 'dbh.php';
require_once 'generalFunctions.php';

$targetDir = '../img/Profile/';
$targetImg = $targetDir.basename($_FILES['file']['name']);
$imageFileType = strtolower(pathinfo($targetImg, PATHINFO_EXTENSION));

$uploadReady = 1;

/* Se presiona el boton */
if(isset($_POST['submit']))
{
    /* Se veridica que si sea una imagen */
    $verify = getimagesize($_FILES['file']['name']);

    if($check === false || file_exists($targetImg) || !allowedImageTypes($imageFileType))
        $uploadReady = 0;
}

if($uploadReady == 0){
    echo "error";
    echo $targetImg;
}
else
{
    $query = "UPDATE Foto_Perfil SET Direccion='$targetImg' WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    mysqli_query($conn, $query);
    
    move_uploaded_file($_FILES['file']['tmp_name'], $targetImg);


    mysqli_close($conn);
    
    echo $targetImg;
    
}


?>