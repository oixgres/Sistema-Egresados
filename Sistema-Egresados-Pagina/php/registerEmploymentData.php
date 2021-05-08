<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario       : INT
 *	laborando       : BIT(1)
 *	empleo          : VARCHAR(45)
 *	empresa         : VARCHAR(45)
 *	puesto          : VARCHAR(45)
 *	categoria       : VARCHAR(45)
 *	correo          : VARCHAR(45)
 *	departamento    : VARCHAR(45)
 *	tecnologias     : VARCHAR(200)
 *	actividades     : VARCHAR(200)
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

$idUsuario    = $_POST['idUsuario'];
$laborando    = $_POST['laborando'];
$empleo       = $_POST['empleo'];
$empresa      = $_POST['empresa'];
$puesto       = $_POST['puesto'];
$categoria    = $_POST['categoria'];
$correo       = $_POST['correo'];
$departamento = $_POST['departamento'];
$tecnologias  = $_POST['tecnologias'];
$actividades  = $_POST['actividades'];

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";  // confirmar que existe idUsuario
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

if ($laborando === 1) {
    $sql = "INSERT INTO datos_laborales(Usuario_idUsuario, Labora, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades)
            VALUES (${idUsuario}, 1, '${empleo}', '${empresa}', '${puesto}', '${categoria}', '${correo}', '${departamento}', '${tecnologias}', '${actividades}')";
} else {
    $sql = "INSERT INTO datos_laborales(Usuario_idUsuario, Labora)
            VALUES (${idUsuario}, 0)";
}

if (mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();