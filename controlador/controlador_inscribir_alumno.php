<?php

include ("../conexion.php");

if(isset($_POST['btn_inscribir_alumno'])){

    if((!empty($_POST['dni_alumno_inscribir'])) && (!empty($_POST['id_materia_inscribir']))){
        $dni_alumno = $_POST['dni_alumno_inscribir'];
        $id_materia = $_POST['id_materia_inscribir'];
    
        $consulta_confirmacion = $conexion -> query("
        SELECT 
        a.id_alumno,
        a.nombre_alumno,
        m.nombre_materia
        FROM alumnos a, materias m
        WHERE
        dni_alumno = $dni_alumno
        AND id_materia = $id_materia   
        ;");



        if($conexion -> affected_rows > 0){
            $fila = $consulta_confirmacion -> fetch_assoc();
            $nombreA = $fila['nombre_alumno'];
            $nombreM = $fila['nombre_materia'];
            $id_alumno = $fila['id_alumno'];

            echo "Desea inscribir a " , $nombreA , " en  " , $nombreM, "?";

            ?>
            <form method="post">
                <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">
                <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                <input type="submit" name="btn_confirmar_inscripcion" value="Confirmar"> 
                <input type="submit" name="btn_cancelar_inscripcion" value="Cancelar"> 

            </form>
            <?php
        }else{
            echo "<script>mostrarMensaje('DNI inexistente')</script>";
        }



    
    }

    if(empty($_POST['dni_alumno_inscribir']) OR empty($_POST['id_materia_inscribir'])){
        echo "<script>mostrarMensaje('Ingrese todos los datos necesarios')</script>";
    }

}

if(isset($_POST['btn_confirmar_inscripcion'])){
    $id_alumno = $_POST['id_alumno'];
    $id_materia = $_POST['id_materia'];

    $consulta_inscripcion = $conexion -> query("
    INSERT INTO inscripciones (id_alumno, id_materia)
    SELECT $id_alumno, $id_materia
    FROM DUAL
    WHERE NOT EXISTS (
    SELECT 1 
    FROM inscripciones 
    WHERE id_alumno = '$id_alumno' 
    AND id_materia = '$id_materia'
    );"
    );

    if($conexion -> affected_rows > 0){
        echo "<script>mostrarMensaje('Alumno agregado con exito')</script>";  
    }else{
        echo "<script>mostrarMensaje('Alumno no inscripto. Error de base de datos)</script>";
    }
    

}

?>