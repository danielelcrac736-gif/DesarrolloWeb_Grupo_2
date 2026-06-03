<?php

include("../conexion.php");

header("Content-Type: application/json");

$titulo=$_POST["titulo"];
$autor=$_POST["autor"];
$isbn=$_POST["isbn"];
$categoria=$_POST["categoria"];
$stock=$_POST["stock"];

if($stock<0)
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"El stock no puede ser negativo"
    ]);
    exit;
}

$sql="
INSERT INTO libros
(
titulo,
autor,
isbn,
categoria,
stock
)
VALUES
(
'$titulo',
'$autor',
'$isbn',
'$categoria',
'$stock'
)
";

if($conexion->query($sql))
{
    echo json_encode([
        "status"=>"ok",
        "mensaje"=>"Libro registrado correctamente"
    ]);
}
else
{
    echo json_encode([
        "status"=>"error",
        "mensaje"=>"Error al registrar libro"
    ]);
}

?>