<?php

class Conexion
{
    public static function conectar()
    {
        $conexion = null;

        try {
            $conexion = new PDO("mysql:host=localhost;dbname=db_football_association_system", "Administrador", "admin123");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $conexion;
    }
}

?>