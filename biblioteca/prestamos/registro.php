<?php

include("../conexion.php");

$libros=$conexion->query("
SELECT *
FROM libros
WHERE stock>0
");

$usuarios=$conexion->query("
SELECT *
FROM usuarios
");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Registrar Préstamo
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

<div class="card-header bg-dark text-white">

<h3>
Registrar Préstamo
</h3>

</div>

<div class="card-body">

<form id="formPrestamo">

<div class="mb-3">

<label>
Libro
</label>

<select
name="id_libro"
class="form-control"
required
>

<?php
while($libro=$libros->fetch_assoc())
{
?>

<option
value="<?php echo $libro["id"]; ?>"
>

<?php
echo $libro["titulo"];
?>

(
Stock:
<?php
echo $libro["stock"];
?>
)

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>
Usuario
</label>

<select
name="id_usuario"
class="form-control"
required
>

<?php
while($usuario=$usuarios->fetch_assoc())
{
?>

<option
value="<?php echo $usuario["id"]; ?>"
>

<?php
echo $usuario["nombre"];
?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>
Fecha Préstamo
</label>

<input
type="date"
name="fecha_prestamo"
class="form-control"
required
>

</div>

<div class="mb-3">

<label>
Fecha Devolución
</label>

<input
type="date"
name="fecha_devolucion"
class="form-control"
required
>

</div>

<div class="mb-3">

<label>
Observaciones
</label>

<textarea
name="observaciones"
class="form-control"
></textarea>

</div>

<button
type="submit"
class="btn btn-dark"
>
Registrar
</button>

<a
href="lista.php"
class="btn btn-secondary"
>
Ver Préstamos
</a>

</form>

<br>

<div id="mensaje"></div>

</div>

</div>

</div>

<script>

document
.getElementById("formPrestamo")
.addEventListener("submit",function(e)
{

e.preventDefault();

let datos=new FormData(this);

fetch(
"create.php",
{
    method:"POST",
    body:datos
})
.then(
response=>response.json()
)
.then(
data=>
{
    document
    .getElementById("mensaje")
    .innerHTML=
    `
    <div class="alert alert-success">
        ${data.mensaje}
    </div>
    `;

    document
    .getElementById("formPrestamo")
    .reset();
}
);

});

</script>

</body>
</html>