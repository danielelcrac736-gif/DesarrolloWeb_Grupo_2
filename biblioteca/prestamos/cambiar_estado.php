<?php

include("../conexion.php");

header("Content-Type: application/json");

$id=$_POST["id"];
$estado=$_POST["estado"];

if($estado=="Devuelto")
{

    $sql="
    SELECT id_libro
    FROM prestamos
    WHERE id=$id
    ";

    $resultado=$conexion->query($sql);

    $fila=$resultado->fetch_assoc();

    $id_libro=$fila["id_libro"];

    $sql="
    UPDATE libros
    SET stock=stock+1
    WHERE id=$id_libro
    ";

    $conexion->query($sql);

}

$sql="
UPDATE prestamos
SET estado='$estado'
WHERE id=$id
";

if($conexion->query($sql))
{
    echo json_encode([
        "status"=>"ok",
        "mensaje"=>"Estado actualizado correctamente"
    ]);
}
else
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"Error al actualizar estado"
    ]);
}

?>