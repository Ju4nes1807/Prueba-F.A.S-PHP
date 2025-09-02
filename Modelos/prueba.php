<?php

require_once 'Conexion.php'; // Ajusta la ruta según tu estructura
try {
    $conexion = Conexion::conectar();
    if ($conexion) {
        echo "Conexión exitosa a la base de datos.";
    } else {
        echo "No se pudo establecer la conexión.";
    }
} catch (Exception $e) {
    echo "Error al conectar: " . $e->getMessage();
}
?>