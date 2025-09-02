<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/Logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Modificar Perfil</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    // 1. Añade esta línea al inicio para iniciar la sesión
    session_start();

    // 2. Incluye las clases necesarias.
    require_once "../../Modelos/UsuarioDAO.php";
    require_once "../../Modelos/Conexion.php";

    // 3. Verifica si la sesión tiene el ID de usuario.
    if (!isset($_SESSION['user_id'])) {
        echo "Error: Sesión no iniciada o usuario no logueado.";
        // O redirige al login.
        // header("Location: ../inicioSesion.php");
        exit();
    }

    // 4. Usa el ID de la sesión para obtener el usuario.
    $id_usuario = $_SESSION['user_id'];
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->obtenerUsuarioPorId($id_usuario);

    // 5. Verifica si el usuario fue encontrado.
    if (!$usuario) {
        echo "Error: Usuario no encontrado en la base de datos.";
        exit();
    }
    ?>
    <div class="navbar navbar-expand bg-primary lg-4 shadow">
        <a href="landinpage.html">
            <img src="../Images/Logo.png" alt="Logo" class="img-fluid me-2" style="width: 75px; height: 75px;">
        </a>
        <p class="navbar-brand text-light fs-2 shadow">F.A.S</p>
        <div class="collapse navbar-collapse" id="navNavbarDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="dash_admin.php" class="nav-link text-light shadow">Regresar</a>
                </li>
        </div>
    </div>

    <div class="container flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h3 class="mt-5 shadow-sm p-2">Datos</h2>
                    <form id="ModificarPerfil" action="../../Controladores/UsuarioController.php" method="POST">
                        <input type="text" id="nombre" name="nombre" class="form-control mb-3"
                            placeholder="Nombre completo" value="<?php echo $usuario->getNombre(); ?>">
                        <input type="text" id="apellido" name="apellido" class="form-control mb-3"
                            placeholder="Apellidos completos" value="<?php echo $usuario->getApellido(); ?>">
                        <input type="number" id="documento" name="documento" class="form-control mb-3"
                            placeholder="Numero de documento" value="<?php echo $usuario->getDocumento(); ?>">
                        <input type="email" id="correo" name="correo" class="form-control mb-3"
                            placeholder="Correo electronico" value="<?php echo $usuario->getCorreo(); ?>">
                        <label for="fechaNacimiento" class="mb-3">Actualice su fecha de nacimiento</label>
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control mb-3"
                            value="<?php echo $usuario->getCumpleanos(); ?>">
                        <input type="number" id="telefono" name="telefono" class="form-control mb-3"
                            placeholder="Numero de telefono" value="<?php echo $usuario->getTelefono(); ?>">
                        <input type="password" id="contraseñaActual" name="contraseñaActual" class="form-control mb-3"
                            placeholder="Contraseña actual">
                        <input type="password" id="contraseñaNueva" name="contraseñaNueva" class="form-control mb-3"
                            placeholder="Contraseña nueva">
                    </form>
            </div>
        </div>
        <div class="container justify-content-center d-flex align-items-center p-4">
            <div class="text-center">
                <input type="submit" class="btn btn-primary fs-6 me-2 shadow" name="btnActualizar"
                    value="Actualizar perfil" form="ModificarPerfil">
            </div>
        </div>
    </div>

    <?php
    // Si hay un mensaje de éxito, lo mostramos
    if (isset($_GET['mensaje'])) {
        $mensaje = urldecode($_GET['mensaje']);
        echo "<div class='alert alert-success text-center mx-auto' style='max-width: 500px;'>$mensaje</div>";
    }

    // Si hay un mensaje de error, lo mostramos
    if (isset($_GET['error'])) {
        $error = urldecode($_GET['error']);
        echo "<div class='alert alert-danger text-center mx-auto' style='max-width: 500px;'>$error</div>";
    }
    ?>


    <footer class="bg-warning py-3 shadow mt-auto">
        <div class="container text-start d-flex align-items-center shadow">
            <img src="../Images/Logo.png" alt="Logo" class="img-fluid me-2" style="width: 75px; height: 75px;">
            <p class="text-dark m-0">© Football Association System. Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="validacionModificarPerfil.js"></script>
</body>

</html>