<?php
function selectorAno($conexion, $name_del_select){

    echo  "<br>";
    echo "<select name=$name_del_select>";
        

    for($i = 1; $i<= 5; $i++ ){
        $selected = "";

        if(isset($_POST[$name_del_select]) && $_POST[$name_del_select] == $i){
            $selected = "selected";
        }

        echo "<option value='$i' $selected>$i</option>";
    };

        
    echo "</select>";



 
}

function selectorSede($conexion, $name_del_select){

        $consultaSedes = "
        SELECT nombre_sede, id_sede
        FROM sedes;";

        $resultado = $conexion -> query($consultaSedes);
        echo  "<br>";
        echo "<select name=$name_del_select>";
            

        while($fila = $resultado -> fetch_assoc()){
            $id_sede = $fila['id_sede'];
            $nombre_sede = $fila['nombre_sede'];

            $selected = "";

            if(isset($_POST[$name_del_select]) && $_POST[$name_del_select] == $id_sede){
                $selected = "selected";
            }

            echo "<option value='$id_sede' $selected>$nombre_sede</option>";
        };

            
        echo "</select>";
}

function selectorMaterias ($conexion , $name_del_select){
            

        $consultaMaterias = "
        SELECT nombre_materia, id_materia, ano_materia
        FROM materias;";

        $resultado = $conexion -> query($consultaMaterias);
        echo  "<br>";
        echo "<select class='form-control' name=$name_del_select>";
            

            while($fila = $resultado -> fetch_assoc()){
                $id_materia = $fila['id_materia'];
                $nombre_materia = $fila['nombre_materia'];
                $ano_materia = $fila['ano_materia'];

                echo "<option value=$id_materia>$ano_materia ° Año - $nombre_materia</option>";
                
            };

            
        echo "</select>";
}

function selectorAlumno($conexion, $name_del_select, $sede, $ano){
   $alumnos = $conexion->query("
    SELECT 
    a.nombre_alumno, 
    a.id_alumno
    FROM alumnos a
    WHERE a.ano_alumno = $ano
    AND a.id_sede = $sede
    ");

    echo  "<br>";
    echo "<select name=$name_del_select>";
        

        while($fila = $alumnos -> fetch_assoc()){
            $id_alumno = $fila['id_alumno'];
            $nombre_alumno = $fila['nombre_alumno'];

            $selected = "";

            if(isset($_POST[$name_del_select]) && $_POST[$name_del_select] == $id_alumno){
                $selected = "selected";
            }

            echo "<option value='$id_alumno' $selected>$nombre_alumno</option>";
            
        };

        
    echo "</select>";

}

function leerNotasAlumno($conexion, $id_inscripcion){
  // Esta funcion lee SOLO las notas de UN alumno en UNA materia y las devuelve como un array asociativo
  $consulta = $conexion ->query("
  SELECT 
  trimestre_nota,
  numero_nota,
  tipo_nota,
  valor_nota
  FROM notas
  WHERE id_inscripcion = $id_inscripcion
  ");

  $notas = [];

  while($fila = $consulta -> fetch_assoc()){
  $trimestre = $fila['trimestre_nota'];
  $numero = $fila['numero_nota'];
  $tipo = $fila['tipo_nota'];
  $valor = $fila['valor_nota'];

  $clasificacion = 'T'.$trimestre.'N'.$numero.$tipo;
  $notas[$clasificacion] = $valor;

  }

  return $notas;

}


function guardarNotasAlumno($conexion, $id_inscripcion, $datos){
        ////////////////                       GUARDADO DE NOTAS

    // Dentro de datos (que es un array asociativo), refierete al indice como "clave" y a su valor como "valor"
    foreach ($datos as $clave => $valor) {
    
    // Si la clave coincide con el patrón:
    // T + uno o más dígitos, N + uno o más dígitos, seguido de letras,
    // entonces se capturan esas partes y se guardan en el array $m. m[0] tiene el array completo y los demas tienen cada parte
    
    if (preg_match('/^T(\d+)N(\d+)([A-Za-z]+)$/', $clave, $m)) {
        $trimestre   = $m[1];
        $numeroNota  = $m[2];
        $tipoNota   = $m[3];

        // Operador ternario: Es un if en una sola linea. Si valor es un string vacio entonces nota vale null, sino nota vale valor
        $notaSQL = ($valor === "") ? NULL : "'$valor'";

        if($notaSQL === NULL){
        $conexion -> query("
        DELETE FROM notas 
        WHERE id_inscripcion = $id_inscripcion
        AND trimestre_nota = $trimestre
        AND numero_nota = $numeroNota
        AND tipo_nota NOT IN ('Promedio', 'NotaTrimestral')
        ");
        }else{
        // Creo la consulta SQL para actuaizar una nota existente
        $update = "UPDATE notas SET valor_nota = $notaSQL
        WHERE id_inscripcion = '$id_inscripcion'
        AND trimestre_nota = '$trimestre'
        AND numero_nota = '$numeroNota'
        AND tipo_nota = '$tipoNota';";
        
        // Ejecuto la consulta SQL
        $conexion -> query($update);

        // Veo si la consulta afecto a alguna fila
        if($conexion -> affected_rows === 0){
        
            //Si la consulta afecto a cero filas me fijo si esa fila existe. Porque afectar a cero filas puede ser porque se cargo la misma nota que ya estaba antes o porque esa nota no existe. Me fijo entonces con un select
            if($notaSQL != NULL){

            $check = $conexion->query("
            SELECT 1 FROM notas
            WHERE id_inscripcion = $id_inscripcion
            AND trimestre_nota = $trimestre
            AND numero_nota = $numeroNota
            AND tipo_nota = '$tipoNota'
            ");
            
            //Si ese select afecto a cero filas entonces esa nota no existe, por lo que no puedo hacer un UPDATE, necesito usar un INSERT el cual CREA la nota, entonces la creo:
            if($check -> num_rows === 0){
                $insert = "INSERT INTO `notas`(
                `id_inscripcion`, 
                `trimestre_nota`, 
                `numero_nota`, 
                `valor_nota`, 
                `tipo_nota`) 
                VALUES (
                $id_inscripcion,
                $trimestre,
                $numeroNota,
                $notaSQL,
                '$tipoNota');";
                $conexion -> query($insert);
            }
            }
        }

        }


        

    }

    }
}

function calcularPromediosAlumno($conexion, $id_inscripcion){
    ////////////////////////////////////////////////// CALCULO DE PROMEDIOS



    $sumatoriaNotasT1 = 0;
    $sumatoriaNotasT2 = 0;
    $sumatoriaNotasT3 = 0;


    // Tomo todas las notas del alumno en cada vuelta
    $resultado = $conexion -> query("
    SELECT 
        trimestre_nota,
        numero_nota,
        valor_nota,
        tipo_nota
    FROM notas
    WHERE id_inscripcion = $id_inscripcion;
    ");


    //Almaceno el resutltado en un array asociativos e itero una vez por cada nota del array
    while( $fila = $resultado->fetch_assoc()){
    
    // Diferencio las notas por trimestre y tipo y hago sus sumatorias 

    switch(true){
        case ($fila['trimestre_nota'] == 1 && ($fila['tipo_nota'] == 'Envio' OR $fila['tipo_nota'] == 'Concepto')):
        $sumatoriaNotasT1 = $sumatoriaNotasT1 + $fila['valor_nota'];
        break;
        
        case($fila['trimestre_nota'] == 2 && ($fila['tipo_nota'] == 'Envio' OR $fila['tipo_nota'] == 'Concepto')):
        $sumatoriaNotasT2 = $sumatoriaNotasT2 + $fila['valor_nota'];
        break;

        case($fila['trimestre_nota'] == 3 && ($fila['tipo_nota'] == 'Envio' OR $fila['tipo_nota'] == 'Concepto')):
        $sumatoriaNotasT3 = $sumatoriaNotasT3 + $fila['valor_nota'];
        break;
    }

    }

    //Usando las sumatorias hago el calculo de promedios
    $promedioT1 = $sumatoriaNotasT1 / 4;
    $promedioT2 = $sumatoriaNotasT2 / 4;
    $promedioT3 = $sumatoriaNotasT3 / 4;

    // Uso un for para escribir las consultas una vez y se haga para todos los trimestres
    for ($i=1; $i < 4 ; $i++) { 
        
    switch($i){
    case 1: $nota = $promedioT1; break;
    case 2: $nota = $promedioT2; break;
    case 3: $nota = $promedioT3; break;
    }
        
    //Cargamos los datos a la db. Hay que verificar que se carguen al alumno correcto
    $update = $conexion -> query("
    UPDATE `notas` SET `valor_nota` = $nota
    WHERE `tipo_nota` = 'Promedio'
    AND `trimestre_nota` = $i
    AND `numero_nota` = 2
    AND `id_inscripcion` = $id_inscripcion;
    ");

    // Chequeamos que el update haya funcionado seleccionando la fila que actualizamos. Si no seleccionamos nada es porque esa nota no existe, entonces mas adelante la creamos

    $check = $conexion -> query("
        SELECT valor_nota 
        FROM notas
        WHERE id_inscripcion = $id_inscripcion
        AND tipo_nota = 'Promedio'
        AND trimestre_nota = $i
    ");

    if($check -> num_rows === 0){
        $insert = $conexion -> query ("
        INSERT INTO `notas` (`tipo_nota`, `valor_nota`, `trimestre_nota`, `numero_nota`, `id_inscripcion`)
        VALUES('Promedio', $nota , $i , 2, $id_inscripcion);
    ");
    }
    
    }
}

function calcularMaximos($conexion, $id_inscripcion){
    /////////////////////////////       DETERMINACION DE MAXIMOS
    // Por logica de negocio se debe conocer cual es mayor entre promedios y recuperatorios por lo que:
  for ($i = 1; $i <= 3; $i++) {

    // Obtengo el máximo entre Promedio y Recuperatorio
    $resultado = $conexion->query("
        SELECT MAX(valor_nota) AS maximo
        FROM notas
        WHERE id_inscripcion = $id_inscripcion
        AND trimestre_nota = $i
        AND tipo_nota IN ('Promedio','Recuperatorio')
    ");

    $fila = $resultado->fetch_assoc();
    $notaTrimestral = $fila['maximo']; // puede ser null

    // Verifico si ya existe un registro NotaTrimestral
    $check = $conexion->query("
        SELECT id_nota
        FROM notas
        WHERE id_inscripcion = $id_inscripcion
        AND trimestre_nota = $i
        AND tipo_nota = 'NotaTrimestral'
    ");

    // Si existe un registro entonces lo actualizo y si no existe lo creo
    if ($check->num_rows > 0) {
      $conexion->query("
          UPDATE notas
          SET valor_nota = " . ($notaTrimestral !== null ? $notaTrimestral : "NULL") . "
          WHERE id_inscripcion = $id_inscripcion
          AND trimestre_nota = $i
          AND tipo_nota = 'NotaTrimestral'
      ");

    } else {
    $conexion->query("
        INSERT INTO notas 
        (id_inscripcion, trimestre_nota, numero_nota, valor_nota, tipo_nota)
        VALUES ($id_inscripcion,$i,4," . ($notaTrimestral !== null ? $notaTrimestral : "NULL") . ",'NotaTrimestral')
    ");
    }
    }

}

function calcularPromTrim($conexion, $id_inscripcion){
    ///////////////////////  DETERMINACION DE PROMEDIO TRIMESTRAL       

    $resultado = $conexion -> query("
    SELECT AVG (valor_nota) AS promedioDeTrimestres FROM notas 
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'NotaTrimestral'
    ");

    $fila = $resultado -> fetch_assoc();
    $promedioDeTrimestres = $fila['promedioDeTrimestres'];


    $check = $conexion -> query("
    SELECT valor_nota 
    FROM notas
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'PromTrim'
    ");

    if($check -> num_rows > 0){
    $conexion -> query("
        UPDATE notas SET valor_nota = $promedioDeTrimestres
        WHERE id_inscripcion = $id_inscripcion
        AND tipo_nota = 'PromTrim'
        AND trimestre_nota = 4
        AND numero_nota = 1
    ");
    }else{
    $conexion -> query("
        INSERT INTO `notas` (`id_inscripcion`, `valor_nota`, `tipo_nota`, `trimestre_nota`, `numero_nota`)
        VALUES ($id_inscripcion, $promedioDeTrimestres, 'PromTrim', 4, 1)
    ");
    }
}

function calcularCalificacionDefinitiva($conexion, $id_inscripcion){
    //  LECTURAS

    $lecturaPromTrim = $conexion -> query("
    SELECT valor_nota
    FROM notas
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'PromTrim'
    AND trimestre_nota = 4
    AND numero_nota = 1
    ");

    $fila = $lecturaPromTrim -> fetch_assoc();
    $promTrim = ($fila && $fila['valor_nota'] !== null && $fila['valor_nota'] !== '') 
        ? (float)$fila['valor_nota'] 
        : null;


    $lecturaDiciembre = $conexion -> query("
    SELECT valor_nota
    FROM notas
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'Diciembre'
    AND trimestre_nota = 4
    AND numero_nota = 2
    ");
    $fila = $lecturaDiciembre -> fetch_assoc();
    $diciembre = ($fila && $fila['valor_nota'] !== null && $fila['valor_nota'] !== '') 
        ? (float)$fila['valor_nota'] 
        : null;


    $lecturaFebrero = $conexion -> query("
    SELECT valor_nota
    FROM notas
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'Febrero'
    AND trimestre_nota = 4
    AND numero_nota = 3
    ");
    $fila = $lecturaFebrero -> fetch_assoc();
    $febrero = ($fila && $fila['valor_nota'] !== null && $fila['valor_nota'] !== '') 
        ? (float)$fila['valor_nota'] 
        : null;


    // Determino la calificacion final 

    if($promTrim !== null && $promTrim >= 6){

        $calificacion = $promTrim;

    } elseif($diciembre !== null && $diciembre >= 6){

        $calificacion = $diciembre;

    } elseif($febrero !== null && $febrero >= 6){

        $calificacion = $febrero;

    } else {

        // Si ninguna llego a 6 entonces tomo la mayor
        $valores = array_filter([$promTrim, $diciembre, $febrero], function($v){
            return $v !== null;
        });

        $calificacion = !empty($valores) ? max($valores) : null;
    }


    // UPDATE / INSERT 

    $conexion -> query("
    UPDATE notas SET valor_nota = $calificacion
    WHERE id_inscripcion = $id_inscripcion
    AND tipo_nota = 'CalifDef'
    AND trimestre_nota = 4
    AND numero_nota = 5
    ");

    if($conexion->affected_rows == 0){
    $conexion -> query("
        INSERT INTO notas (`id_inscripcion`,`valor_nota`,`tipo_nota`,`trimestre_nota`,`numero_nota`)
        VALUES ($id_inscripcion, $calificacion, 'CalifDef', 4, 5);
    ");
    }
}

?>





