<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Registro Usuario
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

<div class="card-header bg-warning">

<h3>
Registro Usuario
</h3>

</div>

<div class="card-body">

<form id="formUsuario">

<div class="mb-3">

<label>Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
required
>

</div>

<div class="mb-3">

<label>Carnet</label>

<input
type="text"
name="carnet"
class="form-control"
required
>

</div>

<div class="mb-3">

<label>Teléfono</label>

<input
type="text"
name="telefono"
class="form-control"
required
>

</div>

<div class="mb-3">

<label>Correo</label>

<input
type="email"
name="correo"
class="form-control"
required
>

</div>

<button
type="submit"
class="btn btn-warning"
>
Guardar
</button>

<a
href="lista.php"
class="btn btn-secondary"
>
Volver
</a>

</form>

<br>

<div id="mensaje"></div>

</div>

</div>

</div>

<script>

document
.getElementById("formUsuario")
.addEventListener("submit",function(e)
{

e.preventDefault();

let datos=new FormData(this);

fetch("create.php",
{
    method:"POST",
    body:datos
})
.then(response=>response.json())
.then(data=>
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
    .getElementById("formUsuario")
    .reset();
});

});

</script>

</body>
</html>