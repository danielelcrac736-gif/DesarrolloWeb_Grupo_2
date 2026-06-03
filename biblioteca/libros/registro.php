<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>
Registro Libro
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

<div class="card-header bg-success text-white">

<h3>
Registro de Libro
</h3>

</div>

<div class="card-body">

<form id="formLibro">

<div class="mb-3">

<label class="form-label">
Título
</label>

<input
type="text"
name="titulo"
id="titulo"
class="form-control"
required
>

</div>

<div class="mb-3">

<label class="form-label">
Autor
</label>

<input
type="text"
name="autor"
id="autor"
class="form-control"
required
>

</div>

<div class="mb-3">

<label class="form-label">
ISBN
</label>

<input
type="text"
name="isbn"
id="isbn"
class="form-control"
required
>

</div>

<div class="mb-3">

<label class="form-label">
Categoría
</label>

<input
type="text"
name="categoria"
id="categoria"
class="form-control"
required
>

</div>

<div class="mb-3">

<label class="form-label">
Stock
</label>

<input
type="number"
name="stock"
id="stock"
class="form-control"
required
min="0"
>

</div>

<button
type="submit"
class="btn btn-success"
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
.getElementById("formLibro")
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
    document.getElementById("mensaje")
    .innerHTML=
    `
    <div class="alert alert-success">
        ${data.mensaje}
    </div>
    `;

    document
    .getElementById("formLibro")
    .reset();
});

});

</script>

</body>
</html>