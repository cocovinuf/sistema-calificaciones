<?php
    include "../conexion.php";
    session_start();

    if(empty($_SESSION["nombre"]) || (empty($_SESSION["rol"]) )){
    header("location:login.php");
    exit();
    }

$rol =  ($_SESSION["rol"]);

if( $rol == 'Tutor'){
    include '../includes/header_tutores.php';
    $tabla = 'tabla_tutores';
    $direccion_tabla = 'tabla_tutores.js';
}else{
    include '../includes/header_profes.php';
    $tabla = 'tabla_profesores';
    $direccion_tabla = 'tabla_profesores.js';
}




 // Leo los parametros pasados por URL y los asigno a una variable
    $_SESSION['id_materia'] = $_GET['id_materia'];
    
    $_SESSION['nombre_materia'] = $_GET['nombre_materia'];
    $nombre_materia = $_SESSION['nombre_materia'];
   
    $_SESSION['ano_materia'] = $_GET['ano_materia'];
    $ano_materia = (int) $_GET['ano_materia'];


    //Comprobacion de que se envio un id_materia
        if (isset($_GET['id_materia'])) {
            $id_materia = (int) $_GET['id_materia'];
            echo "<h2>Materia ID: " . $id_materia . "</h2>";
        }
        if($id_materia < 1 or $id_materia >55){
            echo "<h3>ID de materia no valido</h3>";
            exit;
        }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title><?php echo $ano_materia . ' ' . $nombre_materia ?></title>
</head>
 <body class="bg-dark-subtle">

<!-- TITULO DE MATERIA SELECCIONADA -->
<?php
    echo "<h1>$ano_materia º Año -  $nombre_materia </h1>"
?>





<!--                    TABULATOR               -->
<div id="<?php echo $tabla; ?>" class="m-3"></div>

  <!-- Tabulator CSS (CDN) -->
  <link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator.min.css" rel="stylesheet">

  <!-- Tus estilos -->
  <link rel="stylesheet" href="../estilos.css">

  <!-- Tabulator JS (CDN) -->
  <script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>

  <!-- Tu JS -->
  <script src="../javascript/<?php echo $direccion_tabla; ?>" ></script>
  

</body>


<?php
include "../includes/footer.php";
?>

</html>