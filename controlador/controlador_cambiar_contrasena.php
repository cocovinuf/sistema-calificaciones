<?php
include "../conexion.php";

$id_usuario = $_SESSION["id_usuario"];

if(isset($_POST['btn_solicitud_cambiar_contrasena'])){
?>
    <form method='POST'>
        <label>Ingrese su contraseña actual</label> <br>
        <input type='password' placeholder= 'Contraseña actual' name='contrasena_actual'><br><br>
        <label>Ingrese su contraseña nueva</label><br>
        <input type='password' placeholder='Contraseña nueva' name='contrasena_nueva'><br><br>
        <input type='submit' value='Confirmar cambio de contraseña' name='btn_cambiar_contrasena'>
        <input type='submit' value='Cancelar'>
    </form>
<?php
}



if(isset($_POST['btn_cambiar_contrasena'])){

    if(!empty($_POST['contrasena_actual']) && !empty($_POST['contrasena_nueva'])){
        $contrasena_actual = $_POST['contrasena_actual'];
        $contrasena_nueva = $_POST['contrasena_nueva'];

        $consulta ="
        SELECT contrasena_usuario 
        FROM usuarios
        WHERE id_usuario = $id_usuario
        AND contrasena_usuario = '$contrasena_actual';  
        ";

        $resultado = $conexion -> query($consulta);

        if($resultado && $resultado -> num_rows == 0){
           echo "<script>mostrarMensaje('Contraseña actual INCORRECTA')</script>"; 
        }




        if($resultado && $resultado -> num_rows > 0){
            
            $consulta_update = "
            UPDATE usuarios 
            SET contrasena_usuario = '$contrasena_nueva'
            WHERE id_usuario = $id_usuario;
            ";

            $resultado_update = $conexion -> query($consulta_update);

            if($conexion -> affected_rows > 0){
                echo "<script>mostrarMensaje('La contraseña se cambio exitosamente')</script>";
            }


        }
    }



}




?>