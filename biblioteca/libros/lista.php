<?php

include("../conexion.php");

$sql="
SELECT *
FROM libros
ORDER BY id DESC
";

$resultado=$conexion->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Lista Libros
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

<div class="card-header bg-primary text-white">

<h3>
Lista de Libros
</h3>

</div>

<div class="card-body">

<a
href="registro.php"
class="btn btn-success mb-3"
>
Nuevo Libro
</a>

<table
class="table table-bordered table-hover"
>

<tr>

<th>ID</th>

<th>Título</th>

<th>Autor</th>

<th>ISBN</th>

<th>Categoría</th>

<th>Stock</th>

<th>Editar</th>

<th>Eliminar</th>

</tr>

<?php
while(
$fila=$resultado->fetch_assoc()
)
{
?>

<tr>

<td>
<?php echo $fila["id"]; ?>
</td>

<td>
<?php echo $fila["titulo"]; ?>
</td>

<td>
<?php echo $fila["autor"]; ?>
</td>

<td>
<?php echo $fila["isbn"]; ?>
</td>

<td>
<?php echo $fila["categoria"]; ?>
</td>

<td>
<?php echo $fila["stock"]; ?>
</td>

<td>

<a
href="update.php?id=<?php echo $fila["id"]; ?>"
class="btn btn-warning"
>
Editar
</a>

</td>

<td>

<button
class="btn btn-danger"
onclick="eliminarLibro(
<?php echo $fila['id']; ?>
)"
>
Eliminar
</button>

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

function eliminarLibro(id)
{

if(
confirm(
"¿Desea eliminar este libro?"
)
)
{

fetch(
"delete.php?id="+id
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

}

</script>

</body>
</html>