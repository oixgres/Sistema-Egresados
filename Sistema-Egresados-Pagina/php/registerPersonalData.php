<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario       : INT
 *	fechaNacimiento : DATE
 *  idEstado        : INT
 *  idCiudad        : INT
 *	domicilio       : VARCHAR(45)
 *	telefono        : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe usuario
 *  -3 : Error al registrar datos
*/

if (!isset($_POST['idUsuario'])) {
    echo -1;
    $conn->close();
    exit();
}

$idUsuario       = $_POST['idUsuario'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$idEstado        = $_POST['idEstado'];
$idCiudad        = $_POST['idCiudad'];
$domicilio       = $_POST['domicilio'];
$telefono        = $_POST['telefono'];

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";  // confirmar que existe idUsuario
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "INSERT INTO Datos_Personales(Usuario_idUsuario, Fecha_Nacimiento, Estado_idEstado, Ciudad_idCiudad, Domicilio, Telefono)
        VALUES (${idUsuario}, '${fechaNacimiento}', ${idEstado}, ${idCiudad}, '${domicilio}', '${telefono}')";

if (mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();