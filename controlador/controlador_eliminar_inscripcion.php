<?php

include("../conexion.php");

if(isset($_POST['btn_eliminar_inscripcion'])){
    
    if((!empty($_POST['dni_alumno_elim_insc'])) && (!empty($_POST['id_materia_elim_insc']))){

        $dni_alumno = $_POST['dni_alumno_elim_insc'];
        $id_materia = $_POST['id_materia_elim_insc'];
        
        $consulta = $conexion->query(
        "SELECT
            a.id_alumno,
            a.nombre_alumno, 
            m.nombre_materia 
        FROM (alumnos a, materias m) 
        WHERE dni_alumno = '$dni_alumno'
        AND id_materia = '$id_materia'
        ;");

        if($consulta && $consulta -> num_rows > 0){
            $datos_eliminacion_inscripcion = $consulta -> fetch_assoc();
            $id_alumno = $datos_eliminacion_inscripcion['id_alumno'];
            $nombre = $datos_eliminacion_inscripcion['nombre_alumno'];
            $materia = $datos_eliminacion_inscripcion['nombre_materia'];
            
            echo "Desea eliminar a " . $nombre . " de " . $materia . "?";

            ?>
            <form method="post">
                <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">
                <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                <input type = "submit" value="Confirmar eliminacion" name="btn_confirmar_elim_insc">
                <input type = "submit" value="Cancelar" name="btn_cancelar_elim_insc">
            </form>
            <?php



        }else{echo "<script>mostrarMensaje('No existe ningun alumno con ese DNI')</script>";}
    }else{echo "<script>mostrarMensaje('Debe cargar todos los datos del alumno a eliminar')</script>";}
}


if(isset($_POST['btn_confirmar_elim_insc'])){
    $id_alumno = $_POST['id_alumno'];
    $id_materia = $_POST['id_materia'];

    

    $eliminacion = $conexion -> query("
    DELETE FROM inscripciones 
    WHERE id_alumno = '$id_alumno' 
    AND id_materia = '$id_materia';
    ");

    if($conexion -> affected_rows > 0){
        echo "<script>mostrarMensaje('Inscripcion eliminada')</script>";
    }else{
        echo "<script>mostrarMensaje('La consulta por alguna razon no se hizo')</script>";
    }
  
}




?>