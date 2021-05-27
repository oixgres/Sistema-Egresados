<?php
require_once "dbh.php";
/*
 * Devuelve:
 * 	(JSON)
 *  idCategoria      : INT
 *  Nombre           : VARCHAR(200)
 *
 *  Códigos de error:
 *  -1 : Error consultando categorias
*/

$json = array();
$sql = "SELECT * FROM Categoria";
$res = mysqli_query($conn, $sql);

if (gettype($res) != "boolean" and $res->num_rows != 0) {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idCategoria' => $fila['idCategoria'],
            'Nombre' => $fila['Nombre']
        );
    }
    /* JSON Ejemplo:
     *  string(41) "[{"idCategoria":"1","Nombre":"Hardware"}]"
     */
    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontend
} else {
    echo -1;
}

$conn->close();