<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Registrese</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .registro-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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

<?php
require_once("../Modelos/Conexion.php");
require_once("../Modelos/RolDAO.php");

$rolDAO = new RolDAO();
$roles = $rolDAO->listarRoles();
?>

<body class="d-flex flex-column min-vh-100">
    <div class="navbar navbar-expand-md bg-primary shadow mb-4">
        <a href="landinpage.html" class="d-flex align-items-center">
            <img src="Images/Logo.png" alt="Logo" class="img-fluid me-2" style="width: 75px; height: 75px;">
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

    <div class="registro-container">
        <h3 class="text-center mb-4">Registro de Usuario</h3>
        <form action="../Controladores/UsuarioController.php" method="POST">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese sus nombres"
                    required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos"
                    placeholder="Ingrese sus apellidos" required>
            </div>

            <div class="row mb-3">
                <div class="mb-3">
                    <label for="numeroDocumento" class="form-label">Número de Documento</label>
                    <input type="text" class="form-control" name="numeroDocumento" id="numeroDocumento"
                        placeholder="Ej: 1234567890" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com"
                    required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Ej: 3001234567"
                    required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" required>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['id'] ?>"><?= $rol['type'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-5">
                <label for="Contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña"
                    required>
            </div>


            <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="RegistrarBtn">Registrarse</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_GET['mensaje'])) {
        // La alerta se mostrará en rojo si el mensaje empieza con "Error:"
        $clase_alerta = strpos(urldecode($_GET['mensaje']), "Error:") !== false ? "alert-danger" : "alert-success";

        // Envuelve la alerta en un contenedor para limitar su ancho
        echo '<div class="container mt-4">'; // Agregamos un margen superior
        echo '    <div class="row justify-content-center">'; // Centra la columna
        echo '        <div class="col-md-6">'; // Ocupa 6 de las 12 columnas en pantallas medianas y grandes
        echo '            <div class="alert ' . $clase_alerta . ' text-center" role="alert">';
        echo '                ' . htmlspecialchars(urldecode($_GET['mensaje']));
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    ?>

    <footer class="bg-warning py-3 shadow mt-auto">
        <div class="container text-start d-flex align-items-center footer-content shadow">
            <img src="Images/Logo.png" alt="Logo" class="img-fluid me-2" style="width: 75px; height: 75px;">
            <p class="text-dark m-0">© Football Association System. Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/validaciones-registro.js"></script>
</body>

</html>