<?php

include("../conexion.php");

if(isset($_POST["guardar"]))
{
    header("Content-Type: application/json");

    $id=$_POST["id"];
    $titulo=$_POST["titulo"];
    $autor=$_POST["autor"];
    $isbn=$_POST["isbn"];
    $categoria=$_POST["categoria"];
    $stock=$_POST["stock"];

    if($stock<0)
    {
        echo json_encode([
            "status"=>"error",
            "mensaje"=>"Stock inválido"
        ]);
        exit;
    }

    $sql="
    UPDATE libros
    SET
    titulo='$titulo',
    autor='$autor',
    isbn='$isbn',
    categoria='$categoria',
    stock='$stock'
    WHERE id=$id
    ";

    if($conexion->query($sql))
    {
        echo json_encode([
            "status"=>"ok",
            "mensaje"=>"Libro actualizado"
        ]);
    }
    else
    {
        echo json_encode([
            "status"=>"error",
            "mensaje"=>"Error al actualizar"
        ]);
    }

    exit;
}

$id=$_GET["id"];

$sql="
SELECT *
FROM libros
WHERE id=$id
";

$resultado=$conexion->query($sql);

$fila=$resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Editar Libro</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet"
>

</head>

<body>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Editar Libro</h3>

</div>

<div class="card-body">

<form id="formEditar">

<input
type="hidden"
name="id"
value="<?php echo $fila["id"]; ?>"
>

<div class="mb-3">

<label>Título</label>

<input
type="text"
name="titulo"
class="form-control"
value="<?php echo $fila["titulo"]; ?>"
required
>

</div>

<div class="mb-3">

<label>Autor</label>

<input
type="text"
name="autor"
class="form-control"
value="<?php echo $fila["autor"]; ?>"
required
>

</div>

<div class="mb-3">

<label>ISBN</label>

<input
type="text"
name="isbn"
class="form-control"
value="<?php echo $fila["isbn"]; ?>"
required
>

</div>

<div class="mb-3">

<label>Categoría</label>

<input
type="text"
name="categoria"
class="form-control"
value="<?php echo $fila["categoria"]; ?>"
required
>

</div>

<div class="mb-3">

<label>Stock</label>

<input
type="number"
name="stock"
class="form-control"
value="<?php echo $fila["stock"]; ?>"
min="0"
required
>

</div>

<button
type="submit"
class="btn btn-warning"
>
Actualizar
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
.getElementById("formEditar")
.addEventListener("submit",function(e)
{

e.preventDefault();

let datos=new FormData(this);

datos.append("guardar","1");

fetch(
"update.php",
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
}
);

});

</script>

</body>
</html>