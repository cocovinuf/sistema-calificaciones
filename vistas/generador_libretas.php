<!--                    INICIO DE SESION                  -->
<?php
    session_start();
    if(empty($_SESSION["nombre"])){
    header("location:login.php");
    exit();
    }

    
?>
<!--                    PARTE HTML                -->

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../javascript/main.js"></script>
        <script src='../javascript/mostrar_mensaje.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
        <link href="/dist/css/bootstrap/tabulator_bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link href="../estilos/estilos_home_admin.css" rel="stylesheet">
        <title>Administrador</title>
    </head>
<body class="bg-dark-subtle">

<?php
include "../conexion.php";
include "../funciones_php/funciones.php";
include "../includes/header_admin.php";
?>

<div class="container-fluid">

<!--                    TABULATOR               -->


<form method="POST">
    <label>Sede</label>
    <?php selectorSede($conexion,'id_sede_libretas'); ?><br><br>
    <label>Año</label>
    <?php selectorAno($conexion,'ano_libretas'); ?>
    <input type="submit" name="btn_solicitar_curso_libreta" value="Elegir curso">
</form>

<?php
    if(isset($_POST['btn_solicitar_curso_libreta'])){
        if(!empty($_POST['id_sede_libretas']) AND !empty($_POST['ano_libretas'])){
            $id_sede = $_POST['id_sede_libretas'];
            $ano = $_POST['ano_libretas'];
            selectorAlumno($conexion,'nombre_alumno_libreta', $id_sede, $ano);   
            echo
            "<br><br>
            <form method='POST'>
            <input type='button' id='btn_solicitar_libreta' value='Solicitar Libreta'>  
            </form>";
        }
    }    
?>
<br><br>
<h3>Tabla de libretas</h3>

<button id="download-pdf" class="">Descargar Libreta</button>
<br><br>

</div>

  <div id="tabla_libretas" class="m-5"></div>



  <!-- Tabulator CSS (CDN) -->
  <link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator.min.css" rel="stylesheet">

  <!-- Tabulator JS (CDN) -->
  <script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>

  <!-- JS -->
<script src="../javascript/tabla_libretas.js"></script>


</body>

<?php
include '../includes/footer.php';
?>


