<?php

include("../conexion.php");

header("Content-Type: application/json");

$id_libro=$_POST["id_libro"];
$id_usuario=$_POST["id_usuario"];
$fecha_prestamo=$_POST["fecha_prestamo"];
$fecha_devolucion=$_POST["fecha_devolucion"];
$observaciones=$_POST["observaciones"];

$sql="
SELECT stock
FROM libros
WHERE id=$id_libro
";

$resultado=$conexion->query($sql);

$fila=$resultado->fetch_assoc();

if($fila["stock"]<=0)
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"No existe stock disponible"
    ]);

    exit;
}

$sql="
INSERT INTO prestamos
(
id_libro,
id_usuario,
fecha_prestamo,
fecha_devolucion,
observaciones
)
VALUES
(
'$id_libro',
'$id_usuario',
'$fecha_prestamo',
'$fecha_devolucion',
'$observaciones'
)
";

if($conexion->query($sql))
{

    $sql="
    UPDATE libros
    SET stock=stock-1
    WHERE id=$id_libro
    ";

    $conexion->query($sql);

    echo json_encode([
        "status"=>"ok",
        "mensaje"=>"Préstamo registrado correctamente"
    ]);

}
else
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"Error al registrar préstamo"
    ]);
}

?>