<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idAdmin : INT
 *
 * Devuelve:
 *
 *  Nombre de la universidad : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idAdmin
 *  -2 : No existe el idAdmin en la base de datos
*/

if(isset($_POST['idAdmin'])) {
    $idAdmin = $_POST['idAdmin'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idAdmin, Universidad_idUniversidad FROM Admin WHERE idAdmin = ${idAdmin}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
} else {
    $idUniversidad = mysqli_fetch_assoc($res)['Universidad_idUniversidad'];

    $sql = "SELECT idUniversidad,Nombre FROM Universidad WHERE idUniversidad = ${idUniversidad}";
    $res = mysqli_query($conn, $sql);

    $values = mysqli_fetch_array($res);

    $json = [
        'Nombre' => $values['Nombre'],
        'idUniversidad' => $values['idUniversidad'],
    ];


    echo json_encode($json);
}

$conn->close();