<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../estilos/estilos_login.css" rel="stylesheet">
    <title>Planillas ESRTIC</title>
</head>
<body>


<!--                    CAJA CON CAMPOS DEL LOGIN               -->
<div class="caja-login">
    <H1>Planillas de calificaciones para colegio virtual rural</H1>
    <h2>Ingresar a su cuenta</h2>

    <?php
    include "../conexion.php";
    include "../controlador/controlador_login.php";
    ?>

    <form method="post">

    <input type="text" name="usuario" placeholder="Ingrese el usuario" class="campos-login">
    <input type="password" name="contrasena" placeholder="Ingrese la contraseña" class="campos-login"> 
    <br><br>
    <input type="submit" name="btn_ingresar" value="Iniciar sesion" class="boton-login"> 

    </form> 
<h3><a href="sobre_pagina.php">¿De que trata esta pagina?</a></h3>


</div>

</body>
</html>