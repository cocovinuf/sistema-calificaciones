<header>

    <!-- Barra superior -->
    <div class="container-fluid">
        <div class="row align-items-center g-0">

            <div class="col-xl-11">
                <h1 class="m-1 bg-success p-5">
                    Bienvenid@, <?php echo $_SESSION["nombre"]; ?>
                </h1>
            </div>

            <div class="col-xl-1 text-end">
                <a href="../vistas/home_admin.php">
                    <img 
                        src="../imagenes/logo.png"
                        alt="logo de la escuela"
                        class="img-fluid"
                        style="max-width:150px;">
                </a>
            </div>

        </div>
    </div>

    <!-- Botones -->
    <div class="container-fluid">
        <div class="row m-3">

            <div class="col-xl-2">
                <a 
                    class="btn btn-secondary w-100 d-flex justify-content-center align-items-center"
                    href="seleccion_materia.php">
                    Volver a lista de materias
                </a>
            </div>

            <div class="col-xl-2">
                <form method="POST">
                    <input 
                        type="submit"
                        name="btn_solicitud_cambiar_contrasena"
                        value="Quiero cambiar mi contraseña"
                        class="btn btn-secondary w-100">
                </form>
            </div>

            <?php include "../controlador/controlador_cambiar_contrasena.php"; ?>

            <div class="col-xl-2">
                <a 
                    class="btn btn-danger w-100 d-flex justify-content-center align-items-center"
                    href="../controlador/controlador_cerrar_sesion.php">
                    Cerrar Sesion
                </a>
            </div>

        </div>
    </div>

</header>