<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario    : INT
 *
 * Devuelve:
 *  Direccion    : TEXT
 *
 *  Códigos de error:
 *  -1 : No se mando idUsuario
 *  -2 : No existe usuario
 *  -3 : No existe foto
*/

if(isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";  // confirmar que existe idUsuario
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT Direccion FROM Foto_Perfil WHERE Usuario_idUsuario = ${idUsuario}";
$res = mysqli_query($conn, $sql);
                                                                // Ejemplo
if(gettype($res) != "boolean" and $res->num_rows != 0) {        // string(22) "/ruta/carpeta/foto.jpg"
    echo mysqli_fetch_assoc($res)['Direccion'];                 // retornar ruta al frontend
} else {
    echo -3;
}

$conn->close();