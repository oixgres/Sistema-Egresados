<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idPregunta : INT
 *
 * Devuelve:
 * 	Ordenados por ID, todas las respuestas de la pregunta
 *
 *  (JSON)
 *  IdRespuesta : INT
 *	Texto : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idPregunta
 *  -2 : No existe pregunta
 *  -3 : No existen respuestas
*/

if(isset($_POST['idPregunta'])) {
    $idPregunta = $_POST['idPregunta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idPregunta FROM Pregunta WHERE idPregunta = '$idPregunta'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idRespuesta, Respuesta FROM Respuesta
        INNER JOIN Pregunta ON Respuesta.Pregunta_idPregunta = Pregunta.idPregunta
        WHERE Pregunta.idPregunta = '$idPregunta'
        ORDER BY idRespuesta";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean") {
    while($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idRespuesta' => $fila['idRespuesta'],
            'respuesta' => $fila['Respuesta']
        );
    }

    /*
     *	JSON Ejemplo:
     *	   string(101) "[{"idRespuesta":"8","respuesta":"Menos de un mes"},
     *                   {"idRespuesta":"9","respuesta":"1 mes - 6 meses"}]"
    */
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -3;
}

$conn->close();