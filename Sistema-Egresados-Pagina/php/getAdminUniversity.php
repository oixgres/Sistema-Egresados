<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idAdmin : INT
 *
 * Devuelve:
 *
 *  Universidad_idUniversidad : INT
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
    echo mysqli_fetch_assoc($res)['Universidad_idUniversidad'];
}

$conn->close();