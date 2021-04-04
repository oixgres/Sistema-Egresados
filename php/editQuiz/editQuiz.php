<?php
    include("../dbh.php");

    $sql = "SELECT  pregunta.idPregunta as Pregunta,
                    pregunta.Tema,
                    pregunta.Text_Pregunta as Contenido,
                    respuesta.Texto_Respuesta as Respuesta,
                    respuesta.Tipo_respuesta as Tipo
            FROM pregunta
            INNER JOIN respuesta
            ON pregunta.idPregunta = respuesta.idPregunta;";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if(!$result){
        die('Query error'.mysqli_error($conn));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array(
            'Pregunta' => $row['Pregunta'],
            'Tema' => $row['Tema'],
            'Contenido' => $row['Contenido'],
            'Respuesta' => $row['Respuesta'],
            'Tipo' => $row['Tipo']
        );
    }

    $jsonString = json_encode($json);
    echo $jsonString
?>