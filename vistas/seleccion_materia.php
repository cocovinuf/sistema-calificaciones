<?php
    include "../conexion.php";
    session_start();
    if(empty($_SESSION["id_usuario"]) ||
    empty($_SESSION["nombre"]) ||
    empty($_SESSION["rol"])){
    header("location:login.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="../javascript/mostrar_mensaje.js"></script>
    <title>Materias</title>
</head>
 <body class="bg-dark-subtle">

<?php
include "../includes/header_profes.php"
?>


<h3 class="h3 m-1">Materias:</h3>
<!--                    CAJA DEL SELECTOR DE MATERIAS                 -->
<div class="container">
    
    <div class="container-fluid  p-5">
        <?php
            $consulta_materias = "select * from materias where id_profesor = '$_SESSION[id_usuario]'";
            $resultado_materias = mysqli_query($conexion, $consulta_materias);

            while($fila = $resultado_materias -> fetch_array()){
                $nombre_materia = $fila['nombre_materia'];
                $ano_materia = $fila['ano_materia'];
                $id_materia = $fila['id_materia'];
        ?>
        <div class="row">
            <a class="col m-12 btn btn btn-light border 2px dark m-1" href="planilla_materia.php
                ?id_materia=<?= $id_materia ?>
                &nombre_materia=<?= urlencode($nombre_materia)?>
                &ano_materia=<?= urlencode($ano_materia)?>"
            ><?php echo $ano_materia . "º Año - " . $nombre_materia ?> <br><br></a> 
        </div>
        <?php
            }
        ?>
        
    </div>    


</div>



</body>

<?php
include '../includes/footer.php';
?>

</html>