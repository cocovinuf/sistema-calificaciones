<header>
    <div class="container-fluid">
        <div class="row align-items-center g-0">
            
            <div class="col-xl-11">
                <h1 class="m-1 bg-success p-5">
                  Bienvenid@, <?php echo $_SESSION["nombre"]; ?>
                </h1>
            </div>

            <div class="col-xl-1 text-end">
                <a href="../vistas/home_admin.php">
                    <img src="../imagenes/logo.png"
                        alt="logo de la escuela"
                        class="img-fluid "
                        style="max-width: 150px;">
                </a>
            </div>
         </div>
    </div>

    <div class="container-fluid">
        <div class="row">
        <a class="col-xl-2 btn btn-secondary m-3" href="home_admin.php" >Inicio</a>
        <a class="col-xl-2 btn btn-secondary m-3" href="generador_libretas.php" >Ir al generador de libretas</a>
        <a class="col-xl-2 btn btn-danger m-3" href="../controlador/controlador_cerrar_sesion.php" value="Cerrar Sesion">Cerrar Sesion</a>
        
        </div>
    </div>


</header>
