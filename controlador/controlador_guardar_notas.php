<?php

include ("../conexion.php");
require_once("../funciones_php/funciones.php");

//Indica que estoy recibiendo un Json
header("Content-Type: application/json");

// Leo el cuerpo de POST
$input = file_get_contents("php://input");

// convertir JSON a array PHP
$datos = json_decode($input, true);

// Control de excepcion y devolucion de respuesta
if ($datos === null) {
  echo json_encode(["error" => "JSON inválido"]);
  exit;
}

$id_inscripcion = $datos['id_inscripcion'];

guardarNotasAlumno($conexion, $id_inscripcion, $datos);

calcularPromediosAlumno($conexion, $id_inscripcion);

calcularMaximos($conexion, $id_inscripcion);

calcularPromTrim($conexion, $id_inscripcion);

calcularCalificacionDefinitiva($conexion, $id_inscripcion);

$notas_actualizadas = leerNotasAlumno($conexion, $id_inscripcion);


echo json_encode($notas_actualizadas);

