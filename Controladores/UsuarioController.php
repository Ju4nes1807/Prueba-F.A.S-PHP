<?php
require_once "../Modelos/UsuarioDTO.php";
require_once("../Modelos/UsuarioDAO.php");
require_once("../Modelos/Conexion.php");

ini_set('display_errors', 0);
error_reporting(0);

ob_start();

if (isset($_POST["RegistrarBtn"])) {

    $nombre = $_POST["nombres"];
    $apellido = $_POST["apellidos"];
    $documento = $_POST["numeroDocumento"];
    $cumpleanos = $_POST["fechaNacimiento"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $rol = $_POST["rol"];
    $contraseñaSinHash = $_POST["password"];
    $contraseñaHasheada = password_hash($contraseñaSinHash, PASSWORD_DEFAULT);

    $usuarioDTO = new UsuarioDTO();
    $usuarioDTO->setNombre($nombre);
    $usuarioDTO->setApellido($apellido);
    $usuarioDTO->setDocumento($documento);
    $usuarioDTO->setCumpleanos($cumpleanos);
    $usuarioDTO->setCorreo($correo);
    $usuarioDTO->setTelefono($telefono);
    $usuarioDTO->setRol($rol);
    $usuarioDTO->setCon($contraseñaHasheada);

    $usuarioDAO = new UsuarioDAO();
    $mensaje = $usuarioDAO->registrarUsuario($usuarioDTO);

    if (stripos($mensaje, "Usuario registrado correctamente.") !== false) {
        header("Location: ../Vistas/inicioSesion.php?mensaje=" . urlencode($mensaje));
    } else {
        header("Location: ../Vistas/registro.php?mensaje=" . urlencode($mensaje));
    }
    exit();
}

if (isset($_POST["BtnLogin"])) {
    $correo = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->iniciarSesion($correo, $contraseña);

    if ($usuario) {
        session_start();
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['role_id'] = $usuario['fk_role_id'];

        switch ($usuario['fk_role_id']) {
            case 1:
                header("Location: ../Vistas/admin/dash_admin.php");
                break;
            case 2:
                header("Location: ../Vistas/dash_entrenador.php");
                break;
            case 3:
                header("Location: ../Vistas/dash_jugador.php");
                break;
            default:
                header("Location: ../Vistas/landinpage.php");
                break;
        }
        exit();
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
        header("Location: ../Vistas/inicioSesion.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}

if (isset($_POST["btnActualizar"])) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../Vistas/inicioSesion.php?error=no_logueado");
        exit();
    }

    $id = $_SESSION['user_id'];
    $usuarioDAO = new UsuarioDAO();
    $usuarioOriginal = $usuarioDAO->obtenerUsuarioPorId($id);

    if (!$usuarioOriginal) {
        header("Location: ../Vistas/admin/modificarPerfil.php?error=usuario_no_encontrado");
        exit();
    }

    // Campos que pueden actualizarse libremente
    $nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : $usuarioOriginal->getNombre();
    $apellido = !empty($_POST["apellido"]) ? $_POST["apellido"] : $usuarioOriginal->getApellido();
    $documento = !empty($_POST["documento"]) ? $_POST["documento"] : $usuarioOriginal->getDocumento();
    $correo = !empty($_POST["correo"]) ? $_POST["correo"] : $usuarioOriginal->getCorreo();
    $cumpleanos = !empty($_POST["fechaNacimiento"]) ? $_POST["fechaNacimiento"] : $usuarioOriginal->getCumpleanos();
    $telefono = !empty($_POST["telefono"]) ? $_POST["telefono"] : $usuarioOriginal->getTelefono();

    // Por defecto, mantiene la misma contraseña
    $contraseñaParaGuardar = $usuarioOriginal->getCon();

    // Solo si quiere cambiar contraseña, se valida la actual
    if (!empty($_POST["contraseñaNueva"])) {
        $contraseñaActual = $_POST["contraseñaActual"] ?? '';

        if (!password_verify($contraseñaActual, $usuarioOriginal->getCon())) {
            header("Location: ../Vistas/admin/modificarPerfil.php?error=" . urlencode("Contraseña actual incorrecta."));
            exit();
        }

        $contraseñaParaGuardar = password_hash($_POST["contraseñaNueva"], PASSWORD_DEFAULT);
    }

    // Crear DTO actualizado
    $usuarioDTO = new UsuarioDTO();
    $usuarioDTO->setId($id);
    $usuarioDTO->setNombre($nombre);
    $usuarioDTO->setApellido($apellido);
    $usuarioDTO->setDocumento($documento);
    $usuarioDTO->setCorreo($correo);
    $usuarioDTO->setCumpleanos($cumpleanos);
    $usuarioDTO->setTelefono($telefono);
    $usuarioDTO->setCon($contraseñaParaGuardar);

    // Guardar cambios
    $mensaje = $usuarioDAO->actualizarUsuario($usuarioDTO);
    header("Location: ../Vistas/admin/modificarPerfil.php?mensaje=" . urlencode($mensaje));
    exit();
}


?>