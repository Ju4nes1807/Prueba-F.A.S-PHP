<?php
class RolDAO
{
    public function listarRoles()
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT * FROM tb_roles";
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>