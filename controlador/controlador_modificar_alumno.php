<?php
include '../conexion.php';

if(isset($_POST['btn_modificar_alumno'])){  
    if(!empty($_POST['dni_alumno_modif'])){

        $dni_alumno_modif = $_POST['dni_alumno_modif'];

        $check = $conexion -> query("
            SELECT 
            a.nombre_alumno,
            a.id_alumno,
            a.ano_alumno,
            s.nombre_sede
            FROM alumnos a
            LEFT JOIN sedes s
            ON s.id_sede = a.id_sede
            WHERE dni_alumno = $dni_alumno_modif
        "); 
    }else{echo "<script>mostrarMensaje('Debe ingresar el dni del alumno a modificar')</script>";}



    if($check -> num_rows > 0){

        $resultado = $check -> fetch_assoc();
        $nombre_previo = $resultado['nombre_alumno'];
        $dni_previo = $dni_alumno_modif;
        $sede_previa = $resultado['nombre_sede'];
        $ano_previo = $resultado['ano_alumno'];
        $id_alumno = $resultado['id_alumno'];
        
        
        echo "<br>Modificando al alumno: $nombre_previo" . "<br><br>";
            ?>
        <form method="POST">
            <label>Nombre:</label> <br>
            <input type='text' name='nombre_alumno' placeholder='Nombre'><br><br>
            <label>DNI:</label><br>        
            <input type='number' name='dni_alumno' placeholder='DNI'><br>
            
            <input type='hidden' name='nombre_previo' value='<?php echo $nombre_previo;?>'>
            <input type='hidden' name='dni_previo' value='<?php echo $dni_previo;?>'>
            <input type='hidden' name='sede_previa' value='<?php echo $sede_previa;?>'>
            <input type='hidden' name='ano_previo' value='<?php echo $ano_previo;?>'>  
            <input type='hidden' name='id_alumno' value='<?php echo $id_alumno;?>'>       
            <br>
            <label>Sede:</label>
            <?php 
            selectorSede($conexion, 'sede_alumno'); 
            echo "<br><br><label>Año:</label>";
            selectorAno($conexion, 'ano_alumno');
            ?>
            <br><br><input type='submit' name='modif_datos' value='Modificar datos'>

        </form>
        <?php
    }else{echo "<script>mostrarMensaje('No existe ningun alumno con ese DNI')</script>";}





}


if(isset($_POST['modif_datos'])){
    $nombre = $_POST['nombre_alumno'];
    $dni = $_POST['dni_alumno'];
    $sede = $_POST['sede_alumno'];
    $ano = $_POST['ano_alumno'];
    $id_alumno = $_POST['id_alumno'];


    $nombre_previo = $_POST['nombre_previo'];
    $dni_previo = $_POST['dni_previo'];
    $sede_previa = $_POST['sede_previa'];
    $ano_previo = $_POST['ano_previo'];

    if($nombre == null){
        $nombre = $nombre_previo;
    }

    if($sede == null){
        $sede = $sede_previa;
    }

    if($dni == null){
        $dni = $dni_previo;
    }

    if($ano == null){
        $ano = $ano_previo;
    }

    echo "Desea pasar de: 
    <br><br> Nombre: $nombre_previo
    <br><br> DNI: $dni_previo
    <br><br> Sede: $sede_previa
    <br><br> Ano: $ano_previo";

    echo '<br><br>a: ';
    echo"
    <br><br> Nombre: $nombre
    <br><br> DNI: $dni
    <br><br> Sede: $sede
    <br><br> Ano: $ano";

    ?>
    <form method="POST">
        <input type="submit" value="Confirmar Modificacion" name="confir_mod">
        <input type="submit" value="Cancelar">
        <input type="hidden" name='id_alumno' value='<?php echo $id_alumno;?>' >
        <input type="hidden" name='nombre' value='<?php echo $nombre;?>' >
        <input type="hidden" name='dni' value='<?php echo $dni;?>' >
        <input type="hidden" name='sede' value='<?php echo $sede;?>' >
        <input type="hidden" name='ano' value='<?php echo $ano;?>' >
        
    </form>
<?php    
}

if(isset($_POST['confir_mod'])){
    
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $sede = $_POST['sede'];
    $ano = $_POST['ano'];
    $id_alumno = $_POST['id_alumno'];


   $consulta = $conexion -> query("
    UPDATE alumnos
    SET
    nombre_alumno = '$nombre',
    dni_alumno = $dni,
    id_sede = $sede,
    ano_alumno = $ano
    WHERE id_alumno = $id_alumno
    ");

    if($conexion -> affected_rows > 0){
    echo "<script>mostrarMensaje('¡Modificación exitosa!')</script>";
}
}




?>