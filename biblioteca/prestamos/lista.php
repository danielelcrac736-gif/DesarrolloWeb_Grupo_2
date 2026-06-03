<?php

include("../conexion.php");

$filtro_estado="";

if(isset($_GET["estado"]))
{
    $estado=$_GET["estado"];

    if($estado!="")
    {
        $filtro_estado="
        WHERE p.estado='$estado'
        ";
    }
}

$sql="
SELECT
p.*,
l.titulo,
u.nombre
FROM prestamos p
INNER JOIN libros l
ON p.id_libro=l.id
INNER JOIN usuarios u
ON p.id_usuario=u.id
$filtro_estado
ORDER BY p.id DESC
";

$resultado=$conexion->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Lista Préstamos
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet"
>

<link
rel="stylesheet"
href="../css/estilo.css"
>

</head>

<body>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-secondary text-white">

<h3>
Lista de Préstamos
</h3>

</div>

<div class="card-body">

<a
href="registro.php"
class="btn btn-success mb-3"
>
Nuevo Préstamo
</a>

<form method="GET">

<div class="row">

<div class="col-md-4">

<select
name="estado"
class="form-control"
>

<option value="">
Todos
</option>

<option value="Activo">
Activo
</option>

<option value="Devuelto">
Devuelto
</option>

<option value="Vencido">
Vencido
</option>

</select>

</div>

<div class="col-md-2">

<button
class="btn btn-primary"
>
Filtrar
</button>

</div>

</div>

</form>

<br>

<table
class="table table-bordered table-hover"
>

<tr>

<th>ID</th>

<th>Libro</th>

<th>Usuario</th>

<th>Préstamo</th>

<th>Devolución</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

<?php

while(
$fila=$resultado->fetch_assoc()
)
{

$clase="";

if(
$fila["estado"]=="Activo"
&&
$fila["fecha_devolucion"]<date("Y-m-d")
)
{
    $clase="table-danger";
}

?>

<tr class="<?php echo $clase; ?>">

<td>

<?php
echo $fila["id"];
?>

</td>

<td>

<?php
echo $fila["titulo"];
?>

</td>

<td>

<?php
echo $fila["nombre"];
?>

</td>

<td>

<?php
echo $fila["fecha_prestamo"];
?>

</td>

<td>

<?php
echo $fila["fecha_devolucion"];
?>

</td>

<td>

<?php
echo $fila["estado"];
?>

</td>

<td>

<?php
if($fila["estado"]=="Activo")
{
?>

<button
class="btn btn-success"
onclick="
cambiarEstado(
<?php echo $fila['id']; ?>,
'Devuelto'
)
"
>
Devuelto
</button>

<button
class="btn btn-danger"
onclick="
cambiarEstado(
<?php echo $fila['id']; ?>,
'Vencido'
)
"
>
Vencido
</button>

<?php
}
?>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

</div>

<script>

function cambiarEstado(
id,
estado
)
{

fetch(
"cambiar_estado.php",
{
    method:"POST",

    headers:
    {
        "Content-Type":
        "application/x-www-form-urlencoded"
    },

    body:
    "id="+id+
    "&estado="+estado
}
)
.then(
response=>response.json()
)
.then(
data=>
{
    alert(data.mensaje);

    location.reload();
}
);

}

</script>

</body>
</html>