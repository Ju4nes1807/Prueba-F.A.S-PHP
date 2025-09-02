<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Inicia Sesion</title>
    <style>
        body {
            background-color: #f2f2f2;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Agregado para un apilamiento ligeramente mejor en pantallas pequeñas si el contenido del pie de página se ajusta mucho */
        .footer-content {
            flex-direction: column;
            /* Apila los elementos verticalmente por defecto */
        }

        @media (min-width: 576px) {

            /* En pantallas pequeñas y superiores, conviértelo en una fila */
            .footer-content {
                flex-direction: row;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="navbar navbar-expand-md bg-primary shadow mb-4"> <a href="landinpage.html"
            class="d-flex align-items-center"> <img src="Images/Logo.png" alt="Logo" class="img-fluid me-2"
                style="width: 75px; height: 75px;">
            <p class="navbar-brand text-light fs-2 shadow m-0">F.A.S</p>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navNavbarDropdown"
            aria-controls="navNavbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navNavbarDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="landinpage.php" class="nav-link text-light shadow">Regresar</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="login-container">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>
        <form method="POST" action="../Controladores/UsuarioController.php">
            <div class="mb-3" id="loginForm">
                <label for="usuario" class="form-label">Correo Electrónico</label>
                <input type="text" class="form-control" name="usuario" id="usuario"
                    placeholder="Ingrese su Correo Electronico" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contraseña" id="contrasena"
                    placeholder="Ingrese su contraseña" required>
            </div>
            <div class="mb-3 text-end">
                <a href="RecuperarContra.html" class="text-decoration-none">¿Olvidó su contraseña?</a>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="BtnLogin">Ingresar</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_GET['mensaje'])) {
        // Decodifica el mensaje de la URL
        $mensaje = urldecode($_GET['mensaje']);

        // Asigna la clase de la alerta según el contenido del mensaje
        // Si el mensaje es "Usuario registrado correctamente.", la alerta es verde.
        // En cualquier otro caso, la alerta es roja.
        $clase_alerta = strpos($mensaje, "Usuario registrado correctamente.") !== false ? "alert-success" : "alert-danger";

        // Muestra la alerta con la clase dinámica
        echo '<div class="row justify-content-center">';
        echo '    <div class="col-md-6">';
        echo '        <div class="alert ' . $clase_alerta . ' text-center" role="alert">';
        echo htmlspecialchars($mensaje);
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    ?>

    <footer class="bg-warning py-3 shadow mt-auto">
        <div class="container text-start d-flex align-items-center footer-content shadow"> <img src="Images/Logo.png"
                alt="Logo" class="img-fluid me-2" style="width: 75px; height: 75px;">
            <p class="text-dark m-0">© Football Association System. Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validaciones-login.js?v=<?php echo time(); ?>"></script>
</body>

</html>