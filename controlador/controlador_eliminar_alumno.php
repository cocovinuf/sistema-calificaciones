<?php
include "../conexion.php";


if(isset($_POST['btn_elim_alumno'])){
    if(!empty($_POST['dni_alumno_elim'])){
        $dni_alumno_elim = $_POST['dni_alumno_elim'];
        $consulta_nombre_alumno = $conexion->query("SELECT nombre_alumno FROM alumnos WHERE dni_alumno = $dni_alumno_elim");         

        if($conexion -> affected_rows > 0){
            $fila = $consulta_nombre_alumno -> fetch_assoc();
            $nombre_alumno = $fila['nombre_alumno'];
            echo "¿Desea eliminar a: " . $nombre_alumno . "?"; 
            
            ?>  
            <form method="post">
                <input type="hidden" name="dni_alumno_elim" value="<?php echo $dni_alumno_elim; ?>">
                <input type="submit" name="btn_confirmar_elim_alumno" value="Eliminar Alumno">
                <input type="submit" name="btn_cancelar_elim_alumno" value="Cancelar">
            </form>
            <?php
        }else{
            echo "<script>mostrarMensaje('DNI inexistente')</script>";
        }
    }else{echo "<script>mostrarMensaje('Debe rellenar todos los datos')</script>";}

}


    if(isset($_POST['btn_confirmar_elim_alumno'])){
        $dni_alumno_elim = $_POST['dni_alumno_elim'];
        $consulta = $conexion -> query("DELETE FROM alumnos WHERE dni_alumno = $dni_alumno_elim");
        if($consulta){
                echo "<script>mostrarMensaje('Alumno eliminado correctamente')</script>";
        }else{
                echo "<script>mostrarMensaje('No se pudo eliminar al alumno. Error en la base de datos')</script>";
        }
    }

    if(isset($_POST['btn_cancelar_elim_alumno'])){

        echo "<script>mostrarMensaje('Eliminacion cancelada')</script>";

    }


?>