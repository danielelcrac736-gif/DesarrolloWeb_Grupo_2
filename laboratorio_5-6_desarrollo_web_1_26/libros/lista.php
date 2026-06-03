<h2>Listado de Libros</h2>

<?php
include('../conexion.php');
$sql = "SELECT id, titulo, autor, isbn, categoria, stock FROM libros";
$consulta = mysqli_query($con, $sql);

if (mysqli_num_rows($consulta) > 0) {
?>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($libro = mysqli_fetch_assoc($consulta)) { ?>
            <tr>
                <td><?php echo ($libro['titulo']); ?></td>
                <td><?php echo ($libro['autor']); ?></td>
                <td><?php echo ($libro['isbn']); ?></td>
                <td><?php echo ($libro['categoria']); ?></td>
                <td><?php echo $libro['stock']; ?></td>
                <td>
                    <a href="javascript:cargarEditarLibro(<?php echo $libro['id']; ?>)" class="btn-editar">Editar</a>
                    <a href="javascript:eliminarLibro(<?php echo $libro['id']; ?>)" class="btn-eliminar">Eliminar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
} else {
    echo "<p>No hay libros registrados actualmente.</p>";
}
$con->close();
?>