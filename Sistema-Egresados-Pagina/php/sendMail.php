<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	correoUsuario : VARCHAR(45)
 *	asunto : VARCHAR(45)
 *	mensaje : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el correoUsuario o asunto o mensaje
 *  -2 : Error en la operacion para preparar el envio del correo
*/

if(isset($_POST['correoUsuario']) && isset($_POST['asunto']) && isset($_POST['mensaje'])) {
    $correoUsuario = $_POST['correoUsuario'];
    $asunto = $_POST['asunto'];
    $mensaje = "Ha recibido un mensaje de un usuario del Sistema de Egresados:\r\n\r\n";
    $mensaje.= $_POST['mensaje'];

    // Preparar el correo
    $header = "FROM: noreply@SistemaEgresados.com"."\r\n";
    $header.= "Reply-To: noreply@SistemaEgresados.com"."\r\n";
    $header.= "X-Mailer: PHP/".phpversion();

    if (@mail($correoUsuario, $asunto, $mensaje, $header)) {
        echo 0;
    } else {
        echo -2;
    }
} else {
    echo -1;
}

$conn->close();