<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario       : INT
 * 	idUniversidad   : INT
 * 	idCampus        : INT
 * 	idFacultad      : INT
 * 	idPlanEstudio   : INT
 * 	fechaIngreso    : DATE
 * 	fechaEgreso     : DATE
 * 	semestreGrad    : INT
 * 	generacion      : VARCHAR(45)
 * 	fechaTitulacion : DATE
 * 	correo          : VARCHAR(45)
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

$idUsuario      = $_POST['idUsuario'];
$idUniversidad  = $_POST['idUniversidad'];
$idCampus       = $_POST['idCampus'];
$idFacultad     = $_POST['idFacultad'];
$idPlanEstudio  = $_POST['idPlanEstudio'];
$fechaIngreso   = $_POST['fechaIngreso'];
$fechaEgreso    = $_POST['fechaEgreso'];
$semestreGrad   = $_POST['semestreGrad'];
$generacion     = $_POST['generacion'];
$fechaTitulacion= $_POST['fechaTitulacion'];
$correo         = $_POST['correo'];

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";  // confirmar que existe idUsuario
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "INSERT INTO Datos_Escolares(Usuario_idUsuario, Universidad_idUniversidad, Campus_idCampus, Facultad_idFacultad, Plan_Estudio_idPlan_Estudio, Ingreso, Egreso, Semestre_Grad, Generacion, Titulacion, Correo_Inst)
        VALUES (${idUsuario}, ${idUniversidad}, ${idCampus}, ${idFacultad}, ${idPlanEstudio}, '${fechaIngreso}', '${fechaEgreso}', ${semestreGrad}, '${generacion}', '${fechaTitulacion}', '${correo}')";

if (mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();