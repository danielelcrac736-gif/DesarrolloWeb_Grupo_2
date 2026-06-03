<?php

include("../conexion.php");

if(isset($_POST["guardar"]))
{
    $id=$_POST["id"];
    $nombre=$_POST["nombre"];
    $carnet=$_POST["carnet"];
    $telefono=$_POST["telefono"];
    $correo=$_POST["correo"];

    $sql="
    UPDATE usuarios
    SET
    nombre='$nombre',
    carnet='$carnet',
    telefono='$telefono',
    correo='$correo'
    WHERE id=$id
    ";

    $conexion->query($sql);

    header("Location: lista.php");
}

$id=$_GET["id"];

$sql="SELECT * FROM usuarios
WHERE id=$id";

$resultado=$conexion->query($sql);

$fila=$resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
<title>Editar Usuario</title>
</head>
<body>

<form method="POST">

<input
type="hidden"
name="id"
value="<?php echo $fila["id"]; ?>"
>

Nombre:

<input
type="text"
name="nombre"
value="<?php echo $fila["nombre"]; ?>"
>

<br><br>

Carnet:

<input
type="text"
name="carnet"
value="<?php echo $fila["carnet"]; ?>"
>

<br><br>

Telefono:

<input
type="text"
name="telefono"
value="<?php echo $fila["telefono"]; ?>"
>

<br><br>

Correo:

<input
type="email"
name="correo"
value="<?php echo $fila["correo"]; ?>"
>

<br><br>

<button
type="submit"
name="guardar"
>
Guardar
</button>

</form>

</body>
</html>