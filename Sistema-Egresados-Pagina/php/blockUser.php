<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 *
 * Devuelve:
 * 	0 : Bloqueado con exito
 *  1 : Desbloqueado con exito
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe el usuario
 *  -3 : Error al bloquear/desbloquear el usuario
 *  -4 : No se pudo obtener el estatus del usuario.
*/

if (!isset($_POST['idUsuario'])){
    echo -1;
    $conn->close();
    exit();
}

$idUsuario = $_POST['idUsuario'];
$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = {$idUsuario}";
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT Estatus FROM Usuario WHERE idUsuario = {$idUsuario}";
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -4;
    $conn->close();
    exit();
}

$estatus = $res->fetch_row()[0];

$accion = 0;

if($estatus == 'ACTIVO' | $estatus == 'INACTIVO')
{
	$estatus = 'BLOQUEADO';
} 
else if($estatus == 'BLOQUEADO')
{
	$estatus = 'ACTIVO';
	$accion = 1;
}

$sql = "UPDATE Usuario SET Estatus={$estatus} WHERE idUsuario = {$idUsuario}";
if (mysqli_query($conn, $sql)) {
    echo $accion;
} else {
    echo -3;
}

$conn->close();
?>