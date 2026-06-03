<?php

include("../conexion.php");

$sql="
SELECT *
FROM usuarios
ORDER BY id DESC
";

$resultado=$conexion->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Lista Usuarios
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet"
>

</head>

<body>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-info text-white">

<h3>
Lista Usuarios
</h3>

</div>

<div class="card-body">

<a
href="registro.php"
class="btn btn-success mb-3"
>
Nuevo Usuario
</a>

<table
class="table table-bordered table-hover"
>

<tr>

<th>ID</th>
<th>Nombre</th>
<th>Carnet</th>
<th>Teléfono</th>
<th>Correo</th>
<th>Editar</th>
<th>Eliminar</th>

</tr>

<?php
while($fila=$resultado->fetch_assoc())
{
?>

<tr>

<td><?php echo $fila["id"]; ?></td>

<td><?php echo $fila["nombre"]; ?></td>

<td><?php echo $fila["carnet"]; ?></td>

<td><?php echo $fila["telefono"]; ?></td>

<td><?php echo $fila["correo"]; ?></td>

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
onclick="eliminarUsuario(
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

function eliminarUsuario(id)
{

if(confirm("¿Desea eliminar este usuario?"))
{

fetch(
"delete.php?id="+id
)
.then(response=>response.json())
.then(data=>
{
    alert(data.mensaje);

    location.reload();
});

}

}

</script>

</body>
</html>