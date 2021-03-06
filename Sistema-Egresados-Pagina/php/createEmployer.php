<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	Nombre : VARCHAR(200)
 * 	Empresa : VARCHAR(200)
 *
 * Devuelve:
 * 	ID del empleador insertado
 *
 *  idEmpleador : INT
 *
 *  Códigos de error:
 *  -1 : No se mando correctamente alguno de los datos 
 *  -2 : No se pudo insertar el empleador
*/

if(isset($_POST['Nombre'])) {
    $Nombre = $_POST['Nombre'];
} else {
	echo -1;
    $conn->close();
    exit();
}

if(isset($_POST['Empresa'])) {
    $Empresa = $_POST['Empresa'];
} else {
	echo -1;
    $conn->close();
    exit();
}

//Se inserta el empleado

$sql = "INSERT INTO Empleador (Nombre, Empresa) VALUES ('$Nombre', '$Empresa')";
$res = mysqli_query($conn, $sql);

//Si no se pudo insertar el empleado

if($res == false)
{
	echo -2;
    $conn->close();
    exit();
}

//Se devuelve el id del empleado.

echo mysqli_insert_id($conn);

$conn->close();
?>