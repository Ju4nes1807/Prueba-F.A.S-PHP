<?php

require_once "UsuarioDTO.php";
class UsuarioDAO
{

    // Este método debería devolver un valor, como el ID del usuario
    public function registrarUsuario(UsuarioDTO $usuarioDTO)
    {
        $conexion = Conexion::conectar();
        $mensaje = "";

        // Consulta SQL con todos los campos
        $sql = "INSERT INTO tb_users(name, last_name, document, password, phone, email, birthday, asset, fk_role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $conexion->prepare($sql);

            // Vincula los valores a los parámetros
            // El tercer argumento de bindValue() es opcional, pero es buena práctica usarlo
            $stmt->bindValue(1, $usuarioDTO->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(2, $usuarioDTO->getApellido(), PDO::PARAM_STR);
            $stmt->bindValue(3, $usuarioDTO->getDocumento(), PDO::PARAM_INT);
            // La contraseña ya debe estar hasheada en el DTO
            $stmt->bindValue(4, $usuarioDTO->getCon(), PDO::PARAM_STR);
            $stmt->bindValue(5, $usuarioDTO->getTelefono(), PDO::PARAM_STR);
            $stmt->bindValue(6, $usuarioDTO->getCorreo(), PDO::PARAM_STR);
            $stmt->bindValue(7, $usuarioDTO->getCumpleanos(), PDO::PARAM_STR);
            $stmt->bindValue(8, 1, PDO::PARAM_INT); // Valor fijo para asset
            $stmt->bindValue(9, $usuarioDTO->getRol(), PDO::PARAM_INT);

            $stmt->execute();
            $mensaje = "Usuario registrado correctamente.";
        } catch (PDOException $e) {
            $error_code = $e->getCode();
            $error_message = $e->getMessage();

            if ($error_code == 23000) {
                // Este es el código de error para "violación de restricción de integridad"
                if (strpos($error_message, 'email') !== false) {
                    return "Error: El correo electrónico ya está registrado.";
                } else if (strpos($error_message, 'document') !== false) {
                    $mensaje = "Error: El número de documento ya está registrado.";
                } else {
                    $mensaje = "Error: Los datos proporcionados no son válidos.";
                }
            } else {
                // Un mensaje genérico para cualquier otro error
                $mensaje = "Error: Ha ocurrido un error inesperado al registrar el usuario.";
            }
        } finally {
            $conexion = null;
        }

        return $mensaje;
    }

    public function iniciarSesion($correo, $contraseña)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT id, fk_role_id, password FROM tb_users WHERE email = ?";

        try {
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $correo, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contraseña, $usuario['password'])) {
                return $usuario;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        } finally {
            $conexion = null;
        }
    }

    public function obtenerUsuarioPorId($id)
    {
        $conexion = Conexion::conectar();
        $usuarioDTO = null;
        $sql = "SELECT * FROM tb_users WHERE id = ?";

        try {
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $usuarioDTO = new UsuarioDTO();
                $usuarioDTO->setId($row['id']);
                $usuarioDTO->setNombre($row['name']);
                $usuarioDTO->setApellido($row['last_name']);
                $usuarioDTO->setDocumento($row['document']);
                $usuarioDTO->setTelefono($row['phone']);
                $usuarioDTO->setCorreo($row['email']);
                $usuarioDTO->setCumpleanos($row['birthday']);
                $usuarioDTO->setCon($row['password']);
                $usuarioDTO->setRol($row['fk_role_id']);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $conexion = null;
        }

        return $usuarioDTO;
    }

    public function actualizarUsuario(UsuarioDTO $usuarioDTO)
    {
        $conexion = Conexion::conectar();
        $mensaje = "";

        // Construye la consulta SQL de forma dinámica
        $sql = "UPDATE tb_users SET name = ?, last_name = ?, document = ?, phone = ?, email = ?, birthday = ?";
        $parametros = [
            $usuarioDTO->getNombre(),
            $usuarioDTO->getApellido(),
            $usuarioDTO->getDocumento(),
            $usuarioDTO->getTelefono(),
            $usuarioDTO->getCorreo(),
            $usuarioDTO->getCumpleanos()
        ];
        $count = 6; // Contador para los parámetros

        // Agrega la contraseña a la consulta solo si se ha proporcionado
        if ($usuarioDTO->getCon() !== null) {
            $sql .= ", password = ?";
            $parametros[] = $usuarioDTO->getCon();
            $count++;
        }

        $sql .= " WHERE id = ?";
        $parametros[] = $usuarioDTO->getId();

        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $mensaje = "Usuario actualizado correctamente.";
        } catch (PDOException $e) {
            $mensaje = "Error al actualizar el usuario: " . $e->getMessage();
        } finally {
            $conexion = null;
        }
        return $mensaje;
    }
}
?>