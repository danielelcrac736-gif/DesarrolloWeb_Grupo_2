<?php

include("../conexion.php");

header("Content-Type: application/json");

$nombre=$_POST["nombre"];
$carnet=$_POST["carnet"];
$telefono=$_POST["telefono"];
$correo=$_POST["correo"];

$sql="
INSERT INTO usuarios
(
nombre,
carnet,
telefono,
correo
)
VALUES
(
'$nombre',
'$carnet',
'$telefono',
'$correo'
)
";

if($conexion->query($sql))
{
    echo json_encode([
        "status"=>"ok",
        "mensaje"=>"Usuario registrado correctamente"
    ]);
}
else
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"Error al registrar usuario"
    ]);
}

?>