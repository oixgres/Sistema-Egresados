<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *	tipoAlcance : INT
 *		[0 - Universidad    ]
 *		[1 - Campus         ]
 *	  	[2 - Facultad       ]
 *    	[3 - Plan academico ]
 *  idAlcance : INT
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta o tipoAlcance o idAlcance
 *  -2 : No existe el idEncuesta en la base de datos
 *  -3 : No existe el alcance especificado
*/

if (isset($_POST['idEncuesta']) && isset($_POST['tipoAlcance']) && isset($_POST['idAlcance'])) {
    $idEncuesta = $_POST['idEncuesta'];
    $tipoAlcance = $_POST['tipoAlcance'];
    $idAlcance = $_POST['idAlcance'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "CALL updateScope($idEncuesta, $tipoAlcance, $idAlcance)";
$res = mysqli_query($conn, $sql);
$code = mysqli_fetch_array($res)['RESULT'];
echo intval($code);

$conn->close();