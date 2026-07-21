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
            <!--<link href="../estilos/estilos_home_admin.css" rel="stylesheet"> -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <title>Administrador</title>
        </head>
        <body class="bg-dark-subtle">

    <?php
    include "../conexion.php";
    include "../funciones_php/funciones.php";
    include "../includes/header_admin.php";
    ?>






<h2 class="h2 m-3">Herramientas</h2>

<div class="container-fluid">
    <div class="row">


        <!--                    AGREGAR ALUMNO                  -->
        <div class="col-xl-5 bg-secondary-subtle m-3 p-2">
            <h4>Agregar alumno a la lista</h4>
                <form method="post" name="agregar_alumno">
                    <label class="form-label" for="nombre_alumno_agg">Apellido y nombre: </label>
                        <input class="form-control" type="text" placeholder="Apellido y nombre" name="nombre_alumno_agg"><br>

                    <label class="form-label" for="dni_alumno_agg">Dni: </label>
                        <input class="form-control" type="int" placeholder="Dni" name="dni_alumno_agg"><br>


                    <label class="form-label">Sede: </label>
                    <?php
                    selectorSede($conexion, 'sede_alumno_agg');
                    echo "<br> <br> <label class='form-label'>Seleccione el año</label>";
                    selectorAno($conexion, 'ano_alumno_agg');
                    ?>
                    <br>
                    <br>
                    <input class="btn btn-primary btn-lg" type="submit" value="Agregar alumno" name="btn_agg_alumno">
                </form>
                <?php
                include "../controlador/controlador_agregar_alumno.php";
                ?>
        </div>







        <!--                    ELIMINAR ALUMNO                 -->
        <div class="col-xl-5 bg-secondary-subtle  m-3 p-2">
            <h4>Eliminar alumno de la lista</h4>
                <form method="post" name="eliminar_alumno">
                    <label class="form-label" for="dni_alumno_elim">Dni del alumno a eliminar: </label>
                    <input class="form-control" type="int" placeholder="Dni" name="dni_alumno_elim"><br>
                    <input class="btn btn-primary btn-lg" type="submit" value="Eliminar alumno" name="btn_elim_alumno">
                </form>

                <?php
                include "../controlador/controlador_eliminar_alumno.php";
                ?>
        </div>







        <!--                    INSCRIBIR ALUMNO                 -->
        <div class="col-xl-5 bg-secondary-subtle m-3  p-2">
            <h4>Inscribir alumno a materia</h4>
            <form method = "POST">
                <label class="form-label">DNI del alumno a inscribir:</label>
                <input class="form-control" type="text" placeholder="DNI del alumno" name="dni_alumno_inscribir">
            <br>

            <?php
            selectorMaterias ($conexion , 'id_materia_inscribir');
            ?>

                <br><br>
                <input class="btn btn-primary btn-lg" type="submit" name="btn_inscribir_alumno" value="Inscribir alumno">
            </form>

                <?php
                include "../controlador/controlador_inscribir_alumno.php";
                ?>

        </div>

        <!--                    ELIMINAR INSCRIPCION               -->
        <div class="col-xl-5 bg-secondary-subtle  m-3 p-2">
            <h4>Eliminar inscripción de alumno a materia</h4>
            <form method="POST">
                <label class="form-label">DNI del alumno a eliminar inscripcion:</label>
                <input class="form-control" type="text" placeholder="DNI del alumno" name="dni_alumno_elim_insc"><br>
                <?php
                selectorMaterias ($conexion , 'id_materia_elim_insc'); 
                ?>
                <br><br>
                <input class="btn btn-primary btn-lg" type="submit" name="btn_eliminar_inscripcion" value="Eliminar inscripción">    
            </form>

            <?php
                include "../controlador/controlador_eliminar_inscripcion.php";
            ?>
        </div>
        <!--                    MODIFICAR DATOS DE ALUMNO                 -->
        <div class="col-xl-5 bg-secondary-subtle m-3 p-2">
            <h4>Modificar datos de alumno</h4>
            <form method="POST">
                <input class="form-control" type="text" name="dni_alumno_modif" placeholder="DNI del alumno a modificar"><br>
                <input class="btn btn-primary btn-lg" type="submit" value="Seleccionar Alumno" name="btn_modificar_alumno">
            </form>
            <?php
                include '../controlador/controlador_modificar_alumno.php'
            ?>
        </div>
        <br><br>
    </div>
</div>


<!--                    TABULATOR               -->


<h2 class="h2 m-3">Tabla maestra:</h2> <br>

  <div class="m-3" id="tabla_admin"></div>



  <!-- Tabulator CSS (CDN) -->
  <link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator.min.css" rel="stylesheet">

  <!-- Tabulator JS (CDN) -->
  <script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>

  <!-- JS -->
<script src="../javascript/tabla_admin.js"></script>

</body>

<?php
include "../includes/footer.php"
?>

</html>