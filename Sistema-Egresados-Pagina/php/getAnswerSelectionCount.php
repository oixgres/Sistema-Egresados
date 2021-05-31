<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idPregunta    : INT
 *
 * Devuelve numero de usuarios:
 *
 *  (JSON)
 *     respuesta   : titulo de la respuesta
 *     cantidad    : cantidad de egresados que la eligieron
 *
 *  Códigos de error:
 *  -1 : No se mandó el idPregunta
 *  -2 : No existe el idPregunta en la base de datos
 *  -3 : Error en consulta
*/

if(isset($_POST['idPregunta'])) {
    $idPregunta = $_POST['idPregunta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idPregunta FROM Pregunta WHERE idPregunta = ${idPregunta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT Respuesta, COUNT(Usuario_idUsuario) AS cantidad FROM Respuesta_Usuario
        WHERE Pregunta_idPregunta = ${idPregunta}
        GROUP BY Respuesta";
$res = mysqli_query($conn, $sql);
$json = array();

if(gettype($res) != "boolean") {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'respuesta' => $fila['Respuesta'],
            'cantidad' => $fila['cantidad']
        );
    }
}

/*
 * string(142) {"{"respuesta":"Entre 2000 y 4000 MXN al mes","cantidad":"1"},
 *               {"respuesta":"Menos de 2000 MXN al mes","cantidad":"2"}}"
 */

if(!empty($json)) {
    $jsonString = json_encode($json); 	    //convertir el json a cadena
    echo $jsonString;    			        //retornar el json al frontend
} else {
    echo -3;
}

$conn->close();