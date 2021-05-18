<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEstado : INT
 *
 * Devuelve:
 * 	(JSON)
 *  idCiudad : INT
 *  nombre   : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEstado
 *  -2 : Error consultando estados
 *  -3 : Error consultando ciudades
*/

if(isset($_POST['idEstado'])) {
    $idEstado = $_POST['idEstado'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idEstado FROM estado
        WHERE idEstado = ${idEstado}";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean" and $res->num_rows != 0) {
    $sql = "SELECT idCiudad, Nombre as nombre FROM ciudad
            WHERE Estado_idEstado = ${idEstado}";
    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean" and $res->num_rows != 0) {
        while ($fila = mysqli_fetch_array($res)) {
            $json [] = array(
                'idCiudad' => $fila['idCiudad'],
                'nombre' => $fila['nombre']
            );
        }

        /*
         *	JSON Ejemplo:
         *	   string(37) "[{"idCiudad":"1","nombre":"Tijuana"}]"
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