<?php

session_start();
$id_materia = $_SESSION['id_materia'];
include("conexion.php");


// Esta linea le indica al navegador que lo que le vamos a mandar es un json
header("Content-Type: application/json");

$consulta_datos_alumnos = "
SELECT
a.id_alumno,
a.nombre_alumno,
a.ano_alumno,
s.nombre_sede,
n.trimestre_nota,
n.numero_nota,
n.valor_nota,
n.tipo_nota,
i.id_inscripcion
FROM alumnos a
JOIN sedes s
ON a.id_sede = s.id_sede
JOIN inscripciones i
ON i.id_alumno = a.id_alumno
AND i.id_materia = $id_materia
LEFT JOIN notas n
ON n.id_inscripcion = i.id_inscripcion
ORDER BY a.id_alumno;
";

$resultado = $conexion->query($consulta_datos_alumnos);

//Crea una array
$datos_alumnos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos_alumnos[] = $fila;
}

// Tengo que conocer la cantidad de indices que tiene $datos_alumnos, luego crear un bucle for que en la primera vuelta agarre los datos del alumno
// y en todas las demas vueltas agarre todas las notas


$cantidad_datos = count($datos_alumnos);
$id_actual = null;
$indice = -1;

$json_sintetizado = [];

for ($i=0; $i < $cantidad_datos ; $i++) { 

$id_inscripcion = $datos_alumnos[$i]['id_inscripcion']; 
$nombre = $datos_alumnos[$i]['nombre_alumno']; 
$sede = $datos_alumnos[$i]['nombre_sede']; 
$ano = $datos_alumnos[$i]['ano_alumno'];
//Genero primer array asociativo

if ($id_inscripcion != $id_actual) {

    // si no es el primer alumno, no entra. Guarda siempre el alumno de la vuelta anterior
    if ($id_actual !== null) {


    $json_sintetizado[$indice] = array_merge($datos_unificados, $nota_clasificada);
    }

    $indice++;
    
    // Creo para cada alumno su array de notas
    $nota_clasificada = [];
    
    //Seccion DATOS
    //Determino asigno el dato a un indice de array asociativo
    $datos_unificados = [
    'id_inscripcion' => $id_inscripcion,
    'nombre' => $nombre,
    'sede' => $sede,
    'ano' => $ano
    ];

    $id_actual = $id_inscripcion;
}

// Seccion NOTAS
// Determino la clasificacion de la nota
    $trimestre = $datos_alumnos[$i]['trimestre_nota'];
    $numero_nota = $datos_alumnos[$i]['numero_nota'];
    $tipo = $datos_alumnos[$i]['tipo_nota'];
    $valor = $datos_alumnos[$i]['valor_nota'];

//Genero el 2do array asociativo (el de notas)
    $clasificacion_nota = 'T'. $trimestre . 'N' . $numero_nota . $tipo ;
    $nota_clasificada[$clasificacion_nota] = $valor;  

};

// Cargo al ultimo alumno en el array general
$json_sintetizado[$indice] = array_merge($datos_unificados, $nota_clasificada);


echo json_encode($json_sintetizado);