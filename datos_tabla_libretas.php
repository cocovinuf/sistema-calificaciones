<?php
// Esta linea le indica al navegador que lo que le vamos a mandar es un json
header("Content-Type: application/json");

include ("conexion.php");

$id_sede = $_GET['id_sede'] ?? null;
$ano = $_GET['ano'] ?? null;
$id_alumno = $_GET['id_alumno'] ?? 'cae en null';

$datos = [];

if($id_sede && $ano && $id_alumno){
  $consulta = $conexion -> query("
    SELECT 
    n.trimestre_nota,
    n.numero_nota,
    n.tipo_nota,
    n.valor_nota,
    a.nombre_alumno,
    a.ano_alumno,
    a.dni_alumno,
    m.nombre_materia,
    s.nombre_sede
    FROM notas n
    LEFT JOIN inscripciones i
    ON i.id_inscripcion = n.id_inscripcion
    LEFT JOIN alumnos a
    ON a.id_alumno = i.id_alumno
    LEFT JOIN materias m
    ON m.id_materia = i.id_materia
    LEFT JOIN sedes s
    ON s.id_sede = a.id_sede
    WHERE a.id_alumno = $id_alumno
    AND n.tipo_nota NOT IN ('Envio', 'Concepto')
  ");


  while($fila = $consulta -> fetch_assoc()){
    $datos[] = $fila;
  }


}



$datos_modificado = [];



foreach($datos as $nota){

    $materia = $nota['nombre_materia'];
    $nombre_alumno  = $nota['nombre_alumno'];
    $dni_alumno = $nota['dni_alumno'];
    $nombre_sede = $nota['nombre_sede'];
    $ano_alumno = $nota['ano_alumno'];
    
    $trimestre = $nota['trimestre_nota'];
    $numero    = $nota['numero_nota'];
    $tipo      = $nota['tipo_nota'];

    $clasificacion = "T{$trimestre}N{$numero}{$tipo}";

    // Si la materia no existe aún, la creamos
    if(!isset($datos_modificado[$materia])){
      //Dentro del array principal, creá una posición cuya clave sea el nombre de la materia
        $datos_modificado[$materia] = [ //
        // Dentro de ese array hay conjuntos de clave valor, que seran:
            "nombre_materia" => $materia,
            "nombre_alumno"  => $nombre_alumno,
            "dni_alumno" => $dni_alumno,
            "nombre_sede" => $nombre_sede,
            "ano_alumno" => $ano_alumno
        ];
    }

    // Y tambien seran:
    // Agregamos la nota como campo dinamico, se crea una clasificacion por cada vuelta del foreach
    $datos_modificado[$materia][$clasificacion] = $nota['valor_nota'];
}

// Reindexamos para que quede array normal (sin claves asociativas)
$datos_final = array_values($datos_modificado);


echo json_encode($datos_final);