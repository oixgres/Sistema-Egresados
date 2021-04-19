<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *
 * Devuelve:
 * 	Ordenados por ID, todas las preguntas de la encuesta
 *
 *  (JSON)
 *  IdPregunta : INT
 *	Texto : VARCHAR(45)
 *	Tema : VARCHAR(45)
 *  Tipo : INT
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta
 *  -2 : No existe encuesta
 *  -3 : No existen preguntas
*/

if(isset($_POST['idEncuesta'])) {
    $idEncuesta = $_POST['idEncuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idEncuesta FROM Encuesta WHERE idEncuesta = '$idEncuesta'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$json = array();
$sql = "SELECT idPregunta, Pregunta, Tema, Tipo FROM Pregunta
        INNER JOIN Encuesta ON Pregunta.Encuesta_idEncuesta = Encuesta.idEncuesta
        WHERE Encuesta.idEncuesta = '$idEncuesta'
        ORDER BY idPregunta";
$res = mysqli_query($conn, $sql);

if(gettype($res) != "boolean") {
    while($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idPregunta' => $fila['idPregunta'],
            'pregunta' => $fila['Pregunta'],
            'tema' => $fila['Tema'],
            'tipo' => $fila['Tipo']
        );
    }

    /*
     *	JSON Ejemplo:
     *	   string(228) "[{"idPregunta":"3","pregunta":"Cuanto tiempo tardaste en encontrar trabajo?","tipo":"1"},
     *                   {"idPregunta":"5","pregunta":"En que area se especializa tu empresa?","tipo":"1"},
     *                   {"idPregunta":"6","pregunta":"Cuanto ganas?","tipo":"1"}]"
    */
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -3;
}

$conn->close();