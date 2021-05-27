<?php
/*
 * Recibe:
 *	nombreArchivo : String     //Sin terminacion. Eje: Alumnos, Encuesta_ES1
 *	datos : JSON			//Un diccionario de datos JSON (Un array de arrays indexados en formato JSON). 
							Eje: array( array('uno' => 1, 'dos' => 2, 'tres' => 3),
								 		array('uno' => 4, 'dos' => 5, 'tres' => 6),
								 		array('uno' => 7, 'dos' => 8, 'tres' => 9) );
 *	
 * Devuelve:
 *	Descarga un archivo CSV. La primera fila son los nombres de las columnas.
 *  
 * Errores:
 *	-1 : No se ha recibido correctamente alguno de los datos.
 *	-2 :
*/

if(isset($_POST['nombreArchivo'])) {
	$nombreArchivo = $_POST['nombreArchivo'];
} else {
	echo -1;
  	$conn->close();
  	exit();
}

if(isset($_POST['datos'])) {
	$datos = json_decode($_POST['datos'], true); //Convierte el string del JSON a un
												 // array asociativo.
} else {
	echo -1;
  	$conn->close();
  	exit();
}

//ob_clean(); 	//He leido que se recomienda para limpiar el buffer, pero
//ob_start();	// solo me gustaria activarlo si encuentra problemas el procedimiento.

//Se le da terminación .CSV al archivo de descarga.
$nombreArchivo .= '.csv';

header('Content-Type: application/csv; charset=UTF-8'); //Esto no estoy muy seguro como funcione.
header('Content-Disposition: attachment; filename="'.$nombreArchivo.'";');

$archivo = fopen('php://output', 'w');
$delimitador = ',';

fputcsv($archivo, array_keys($datos[0])); //Guarda los nombres de las columnas
									 // en la primera linea del CSV.

foreach ($datos as $fila) {
	fputcsv($archivo, $fila, $delimitador);
}

fpassthru($archivo);

?>