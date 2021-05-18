<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idFacultad : INT
 *
 * Devuelve:
 * 	(JSON)
 *  idPlan_Estudio : INT
 *  nombre         : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idFacultad
 *  -2 : Error consultando facultades
 *  -3 : Error consultando planes de estudio
*/

if(isset($_POST['idFacultad'])) {
    $idFacultad = $_POST['idFacultad'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idFacultad FROM facultad
        WHERE idFacultad = ${idFacultad}";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean" and $res->num_rows != 0) {
    $sql = "SELECT idPlan_Estudio, Nombre as nombre FROM plan_estudio
            WHERE Facultad_idFacultad = ${idFacultad}";
    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean" and $res->num_rows != 0) {
        while ($fila = mysqli_fetch_array($res)) {
            $json [] = array(
                'idPlan_Estudio' => $fila['idPlan_Estudio'],
                'nombre' => $fila['nombre']
            );
        }

        /*
         *	JSON Ejemplo:
         *	   string(60) "[{"idPlan_Estudio":"2","nombre":"Sistemas Computacionales"}]"
        */
        $jsonString = json_encode($json);    //convertir el json a cadena
        echo $jsonString;                    //retornar el json al frontend
    } else {
        echo -3;
    }
} else {
    echo -2;
}

$conn->close();
