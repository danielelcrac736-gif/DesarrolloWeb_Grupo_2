<?php

include("../conexion.php");

header("Content-Type: application/json");

$id=$_GET["id"];

$sql="
DELETE FROM libros
WHERE id=$id
";

if($conexion->query($sql))
{
    echo json_encode([
        "status"=>"ok",
        "mensaje"=>"Libro eliminado correctamente"
    ]);
}
else
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"Error al eliminar"
    ]);
}

?>