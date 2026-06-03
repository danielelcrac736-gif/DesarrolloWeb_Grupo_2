<?php

$conexion=new mysqli(
    "localhost",
    "root",
    "",
    "bd_biblioteca"
);

if($conexion->connect_error)
{
    die("Error de conexion");
}

?>